<?php

namespace App\Listeners;

use App\Events\AttachmentEvent;
use App\Events\StoreAttachmentEvent;
use App\Models\Group;
use App\Models\Template;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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

        $template=Template::findOrFail($event->template_id)->first();
        $students = Group::find($event->group_id)
        ->studentCourses()
        ->with(['student.courses'])
        ->get()
        ->pluck('student')
        ->unique('id')
        ->values();
        event(new StoreAttachmentEvent($students, $template));
    }
}
