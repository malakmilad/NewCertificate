<?php

namespace App\Listeners;

use App\Events\StoreAttachmentEvent;
use App\Mail\ArabicStudentMail;
use App\Mail\EnglishStudentMail;
use App\Mail\StudentMail;
use App\Models\Attachment;
use App\Models\Course;
use App\Models\Font;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use LanguageDetector\LanguageDetector;

class StoreAttachmentListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StoreAttachmentEvent $event): void
    {
        $students = $event->students;
        $template = $event->template;

        foreach ($students as $student) {
            $course_id = $student->course_id;
            $course = Course::find($course_id);

            if ($course) {
                $fonts = Font::get();

                $originalStudentName = $student->name;
                $originalCourseName = $course->name;

                $report = new \ArPHP\I18N\Arabic();
                $student->name = $report->utf8Glyphs($student->name);
                $course->name = $report->utf8Glyphs($course->name);

                $data = [
                    'fonts' => $fonts,
                    'student' => $student,
                    'course' => $course,
                    'template' => $template,
                ];

                $studentAttachment = Pdf::loadView('admin.pdf.view', $data);
                $studentAttachment->setPaper('A4', 'landscape');
                $attachmentPath = public_path('attachment');
                $fileName = "{$originalStudentName}_{$originalCourseName}_{$template->name}.pdf";
                $filePath = "{$attachmentPath}/{$fileName}";
                $studentAttachment->save($filePath);

                Attachment::updateOrCreate([
                    'student_id' => $student->id,
                    'student_name' => $student->name, // This is now from enrollment
                    'course_id' => $course->id,
                    'path' => $filePath,
                ]);

                $detector = new LanguageDetector();
                $language = $detector->evaluate($course->name)->getLanguage();

                try {
                    // Always queue emails since listener itself is queued
                    if ($language == 'ar') {
                        $mail = new ArabicStudentMail($student, $filePath, $course);
                        Mail::to($student->email)->queue($mail);
                        Log::info('Email queued successfully (Arabic)', [
                            'student_email' => $student->email,
                            'student_name' => $originalStudentName,
                            'course' => $originalCourseName
                        ]);
                    } else {
                        $mail = new EnglishStudentMail($student, $filePath, $course);
                        Mail::to($student->email)->queue($mail);
                        Log::info('Email queued successfully (English)', [
                            'student_email' => $student->email,
                            'student_name' => $originalStudentName,
                            'course' => $originalCourseName
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send/queue email', [
                        'student_email' => $student->email,
                        'student_name' => $originalStudentName,
                        'course' => $originalCourseName,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'mailer' => config('mail.default'),
                        'mail_host' => config('mail.mailers.smtp.host'),
                        'queue_connection' => config('queue.default'),
                    ]);
                    // Continue processing other students even if one email fails
                }
            }
        }
    }

}
