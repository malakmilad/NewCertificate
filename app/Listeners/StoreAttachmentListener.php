<?php

namespace App\Listeners;

use App\Events\StoreAttachmentEvent;
use App\Mail\StudentMail;
use App\Models\Attachment;
use App\Models\Course;
use App\Models\Font;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $studentId=$student->id;
            $groupId=$group->id;
            $templateId=$template->id;
            $courses = Course::whereHas('enrollments', function($query) use ($studentId, $groupId, $templateId) {
                $query->where('student_id', $studentId)
                      ->where('group_id', $groupId)
                      ->whereHas('group.templates', function($templateQuery) use ($templateId) {
                          $templateQuery->where('template_id', $templateId);
                      });
            })->get();
            foreach ($courses as $course) {
                if ($course) {
                    $fonts = Font::get();
                    $data=[
                        'fonts' => $fonts,
                        'student' => $student,
                        'course' => $course,
                        'template' => $template,
                    ];
                    $studentAttachment = Pdf::loadView('admin.pdf.view', $data);
                    $attachmentPath = public_path('attachment');
                    $fileName = "{$student->name}_{$course->name}_{$template->name}.pdf";
                    $filePath = "{$attachmentPath}/{$fileName}";
                    $studentAttachment->save($filePath);
                    Attachment::updateOrCreate([
                        'student_id' => $student->id,
                        'path' => $filePath,
                    ]);
                    Mail::to($student->email)->send(new StudentMail($student, $filePath));
                    Log::info('Mail sent successfully to ' . $student->email . ' for course ' . $course->name.' template '.$template->name);
                }
            }
        }
    }

}
