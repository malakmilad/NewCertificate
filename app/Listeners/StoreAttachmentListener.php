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

                // Ar-PHP reshaping removed

                $data = [
                    'fonts' => $fonts,
                    'student' => $student,
                    'course' => $course,
                    'template' => $template,
                ];

                $html = view('admin.pdf.view', $data)->render();

                $attachmentPath = public_path('attachment');
                $fileName = "{$student->name}_{$course->name}_{$template->name}.pdf";
                $filePath = "{$attachmentPath}/{$fileName}";

                \Spatie\Browsershot\Browsershot::html($html)
                    ->setNodeBinary('/home/entlaqa/.nvm/versions/node/v24.12.0/bin/node')
                    ->setNpmBinary('/home/entlaqa/.nvm/versions/node/v24.12.0/bin/npm')
                    ->setNodeModulePath(base_path('node_modules'))
                    ->noSandbox()
                    ->showBackground()
                    ->format('A4')
                    ->landscape()
                    ->margins(0, 0, 0, 0)
                    ->save($filePath);

                Attachment::updateOrCreate([
                    'student_id' => $student->id,
                    'student_name' => $student->name, // This is now from enrollment
                    'course_id' => $course->id,
                    'path' => $filePath,
                ]);

                $detector = new LanguageDetector();
                $language = $detector->evaluate($course->name)->getLanguage();

                if ($language == 'ar') {
                    Mail::to($student->email)->send(new ArabicStudentMail($student, $filePath, $course));
                } else {
                    Mail::to($student->email)->send(new EnglishStudentMail($student, $filePath, $course));
                }
            }
        }
    }

}
