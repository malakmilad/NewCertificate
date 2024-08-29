<?php

namespace App\Listeners;

use App\Events\AttachmentEvent;
use App\Events\StoreAttachmentEvent;
use App\Models\Group;
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
        $template = Template::findOrFail($event->template_id);
        $group = Group::findOrFail($event->group_id);
        $students = $group->studentCourses()
            ->with(['student.courses' => function($query) use ($group) {
                $query->whereHas('groups', function($query) use ($group) {
                    $query->where('group_id', $group->id);
                });
            }])
            ->get()
            ->pluck('student')
            ->unique('id');
        event(new StoreAttachmentEvent($students, $template, $group));
    }

}
