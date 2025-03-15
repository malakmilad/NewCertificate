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
        ->join('enrollment_templates', 'enrollments.group_id', '=', 'enrollment_templates.group_id')
        ->join('students', 'enrollments.student_id', '=', 'students.id')
        ->where('enrollment_templates.template_id', $template->id)
        ->where('enrollment_templates.group_id', $groupId)
        ->select(
            'students.id as id',
            'enrollments.student_name as name',
            'students.email as email'
        )
        ->get();

        event(new StoreAttachmentEvent($students, $template, $group));
    }
}
