<?php

namespace App\Listeners;

use App\Events\AttachmentEvent;
use App\Events\StoreAttachmentEvent;
use App\Models\Enrollment;
use App\Models\Group;
use App\Models\Student;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

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
        $groupId = $event->group_id;
        $template = Template::findOrFail($event->template_id);
        $group = Group::findOrFail($groupId);

        // Use Eloquent to get data with student_name from enrollment
        $students = Enrollment::where('group_id', $groupId)
            ->with(['student', 'course'])
            ->get()
            ->map(function ($enrollment) {
                return (object) [
                    'id' => $enrollment->student->id,
                    'name' => $enrollment->student_name, // Use from enrollment
                    'email' => $enrollment->student->email,
                    'course_id' => $enrollment->course->id,
                    'course_name' => $enrollment->course->name,
                ];
            });

        event(new StoreAttachmentEvent($students, $template, $group));
    }
}
