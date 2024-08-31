<?php

namespace App\Listeners;

use App\Events\StoreAttachmentEvent;
use App\Mail\StudentMail;
use App\Models\Attachment;
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
        // Fetch all courses for the student within the group and template
        $courses = DB::table('courses')
            ->join('student_course', 'courses.id', '=', 'student_course.course_id')
            ->join('group_student_course', 'student_course.id', '=', 'group_student_course.student_course_id')
            ->join('groups', 'group_student_course.group_id', '=', 'groups.id')
            ->join('group_templates', 'groups.id', '=', 'group_templates.group_id')
            ->where('student_course.student_id', $student->id)
            ->where('group_student_course.group_id', $group->id)
            ->where('group_templates.template_id', $template->id)
            ->select('courses.*')
            ->get();  // Fetch all courses, not just the first one

        // Loop through all the courses and generate/send attachments
        foreach ($courses as $course) {
            if ($course) {
                $fonts = Font::get();
                $studentAttachment = Pdf::loadView('admin.pdf.view', [
                    'fonts' => $fonts,
                    'student' => $student,
                    'course' => $course,
                    'template' => $template,
                ]);

                $attachmentPath = public_path('attachment');
                $fileName = "{$student->name}_{$course->name}-{$template->name}.pdf";
                $filePath = "{$attachmentPath}/{$fileName}";
                $studentAttachment->save($filePath);

                // Save the attachment
                Attachment::updateOrCreate([
                    'student_id' => $student->id,
                    'path' => $filePath,
                ]);

                // Send the attachment via email
                Mail::to($student->email)->send(new StudentMail($student, $filePath));

                Log::info('Mail sent successfully to ' . $student->email . ' for course ' . $course->name);
            }
        }
    }
}

}
