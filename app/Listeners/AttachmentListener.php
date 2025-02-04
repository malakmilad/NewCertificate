<?php

namespace App\Listeners;

use App\Events\AttachmentEvent;
use App\Events\StoreAttachmentEvent;
use App\Models\Group;
use App\Models\Student;
use App\Models\Template;

class AttachmentListener
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
    public function handle(AttachmentEvent $event): void
    {
        $groupId  = $event->group_id;
        $template = Template::findOrFail($event->template_id);
        $group    = Group::findOrFail($groupId);
        $students = Student::whereHas('enrollments', function ($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })
            ->with(['enrollments' => function ($query) use ($groupId) {
                $query->where('group_id', $groupId)
                    ->select('id', 'student_id', 'group_id', 'course_id', 'student_name') // Include override
                    ->with('course');
            }])
            ->get()
            ->map(function ($student) {
                $student->name = ! empty($student->enrollments->first()->student_name)
                ? $student->enrollments->first()->student_name : $student->name;
                return $student;
            });

        event(new StoreAttachmentEvent($students, $template, $group));
    }
}
