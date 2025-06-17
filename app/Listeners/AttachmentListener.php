<?php

namespace App\Listeners;

use App\Events\AttachmentEvent;
use App\Events\StoreAttachmentEvent;
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
        $groupId  = $event->group_id;
        $template = Template::findOrFail($event->template_id);
        $group    = Group::findOrFail($groupId);
        $students = DB::table('enrollments')
        ->join('groups', 'enrollments.group_id', '=', 'groups.id')
        ->join('courses', 'enrollments.course_id', '=', 'courses.id')
        ->join('students', 'enrollments.student_id', '=', 'students.id')
        ->where('enrollments.group_id', $groupId)
        ->select(
            'students.id as id',
            'enrollments.student_name as name',
            'students.email as email',
            'courses.id as course_id',
            'courses.name as course_name',
        )
        ->get();
        dd($students);
        event(new StoreAttachmentEvent($students, $template, $group));
    }
}
