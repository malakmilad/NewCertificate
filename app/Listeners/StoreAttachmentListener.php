<?php

namespace App\Listeners;

use App\Events\StoreAttachmentEvent;
use App\Jobs\ProcessStudentCertificate;
use App\Models\Font;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class StoreAttachmentListener implements ShouldQueue
{
    use InteractsWithQueue;
    
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * Optimized: Loads fonts once and dispatches individual jobs for parallel processing
     */
    public function handle(StoreAttachmentEvent $event): void
    {
        $students = $event->students;
        $template = $event->template;

        // Load fonts once (optimization - was loading on every iteration)
        $fonts = Font::get();

        Log::info('Dispatching certificate jobs', [
            'student_count' => count($students),
            'template_id' => $template->id,
        ]);

        // Dispatch individual jobs for each student (enables parallel processing)
        foreach ($students as $student) {
            ProcessStudentCertificate::dispatch($student, $template, $fonts)
                ->onQueue('default');
        }

        Log::info('All certificate jobs dispatched', [
            'student_count' => count($students),
        ]);
    }

}
