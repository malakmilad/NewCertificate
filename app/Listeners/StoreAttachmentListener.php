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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use LanguageDetector\LanguageDetector;

class StoreAttachmentListener
{
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
                    if ($language == 'ar') {
                        Mail::to($student->email)->send(new ArabicStudentMail($student, $filePath, $course));
                        Log::info('Email sent successfully (Arabic)', [
                            'student_email' => $student->email,
                            'student_name' => $originalStudentName,
                            'course' => $originalCourseName
                        ]);
                    } else {
                        Mail::to($student->email)->send(new EnglishStudentMail($student, $filePath, $course));
                        Log::info('Email sent successfully (English)', [
                            'student_email' => $student->email,
                            'student_name' => $originalStudentName,
                            'course' => $originalCourseName
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send email', [
                        'student_email' => $student->email,
                        'student_name' => $originalStudentName,
                        'course' => $originalCourseName,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'mailer' => config('mail.default'),
                        'mail_host' => config('mail.mailers.smtp.host'),
                    ]);
                    // Continue processing other students even if one email fails
                }
            }
        }
    }

}
