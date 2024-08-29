<?php

namespace App\Listeners;

use App\Events\StoreAttachmentEvent;
use App\Mail\StudentMail;
use App\Models\Attachment;
use App\Models\Font;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
        $group = $event->group;
        foreach ($students as $student) {
            $studentCourse = $student->courses->filter(function ($course) use ($group) {
                return $course->groups->contains($group);
            })->first();
            if ($studentCourse) {
                $fonts = Font::get();
                $studentAttachment = Pdf::loadView('admin.pdf.view', [
                    'fonts' => $fonts,
                    'student' => $student,
                    'course' => $studentCourse,
                    'template' => $template,
                ]);
                $attachmentPath = public_path('attachment');
                $fileName = "{$student->name}_{$studentCourse->name}.pdf";
                $filePath = "{$attachmentPath}/{$fileName}";
                $studentAttachment->save($filePath);
                Attachment::updateOrCreate(
                    ['student_id' => $student->id, 'path' => $filePath],
                    ['path' => $filePath]
                );
                Mail::to($student->email)->send(new StudentMail($student, $filePath));
            }
        }
    }
}
