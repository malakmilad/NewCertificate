<?php

namespace App\Listeners;

use App\Events\AttachmentEvent;
use App\Events\StoreAttachmentEvent;
use App\Models\Group;
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
        $template = Template::findOrFail($event->template_id);
        $group = Group::findOrFail($event->group_id);
        $students = DB::table('students')
            ->join('student_course', 'students.id', '=', 'student_course.student_id')
            ->join('group_student_course', 'student_course.id', '=', 'group_student_course.student_course_id')
            ->join('groups', 'group_student_course.group_id', '=', 'groups.id')
            ->join('group_templates', 'groups.id', '=', 'group_templates.group_id')
            ->where('group_templates.template_id', $event->template_id)
            ->where('groups.id', $event->group_id)
            ->select('students.*')
            ->distinct()
            ->get();
        event(new StoreAttachmentEvent($students, $template, $group));
    }

}
