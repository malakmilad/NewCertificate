<?php

namespace App\Jobs;

use App\Mail\ArabicStudentMail;
use App\Mail\EnglishStudentMail;
use App\Models\Attachment;
use App\Models\Course;
use App\Models\Font;
use App\Models\Template;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use LanguageDetector\LanguageDetector;

class ProcessStudentCertificate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $student;
    public $template;
    public $fonts;

    /**
     * Create a new job instance.
     */
    public function __construct($student, Template $template, $fonts)
    {
        $this->student = $student;
        $this->template = $template;
        $this->fonts = $fonts;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $course_id = $this->student->course_id;
        $course = Course::find($course_id);

        if (!$course) {
            Log::warning('Course not found', ['course_id' => $course_id]);
            return;
        }

        $originalStudentName = $this->student->name;
        $originalCourseName = $course->name;

        // Process Arabic text
        $report = new \ArPHP\I18N\Arabic();
        $studentName = $report->utf8Glyphs($this->student->name);
        $courseName = $report->utf8Glyphs($course->name);

        // Create a temporary student object with processed names
        $processedStudent = (object) [
            'id' => $this->student->id,
            'name' => $studentName,
            'email' => $this->student->email,
        ];

        $processedCourse = (object) [
            'id' => $course->id,
            'name' => $courseName,
        ];

        $data = [
            'fonts' => $this->fonts,
            'student' => $processedStudent,
            'course' => $processedCourse,
            'template' => $this->template,
        ];

        // Generate PDF
        $studentAttachment = Pdf::loadView('admin.pdf.view', $data);
        $studentAttachment->setPaper('A4', 'landscape');
        $attachmentPath = public_path('attachment');
        $fileName = "{$originalStudentName}_{$originalCourseName}_{$this->template->name}.pdf";
        $filePath = "{$attachmentPath}/{$fileName}";
        $studentAttachment->save($filePath);

        // Save attachment record
        Attachment::updateOrCreate([
            'student_id' => $this->student->id,
            'student_name' => $studentName,
            'course_id' => $course->id,
        ], [
            'path' => $filePath,
        ]);

        // Detect language and send email
        $detector = new LanguageDetector();
        $language = $detector->evaluate($originalCourseName)->getLanguage();

        try {
            if ($language == 'ar') {
                $mail = new ArabicStudentMail($processedStudent, $filePath, $course);
                Mail::to($this->student->email)->send($mail);
                Log::info('Email sent successfully (Arabic)', [
                    'student_email' => $this->student->email,
                    'student_name' => $originalStudentName,
                    'course' => $originalCourseName
                ]);
            } else {
                $mail = new EnglishStudentMail($processedStudent, $filePath, $course);
                Mail::to($this->student->email)->send($mail);
                Log::info('Email sent successfully (English)', [
                    'student_email' => $this->student->email,
                    'student_name' => $originalStudentName,
                    'course' => $originalCourseName
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send email', [
                'student_email' => $this->student->email,
                'student_name' => $originalStudentName,
                'course' => $originalCourseName,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // Re-throw to mark job as failed
        }
    }
}
