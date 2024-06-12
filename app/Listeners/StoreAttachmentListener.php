<?php

namespace App\Listeners;

use App\Events\StoreAttachmentEvent;
use App\Mail\StudentMail;
use App\Models\Attachment;
use App\Models\Font;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        $students=$event->students;
        foreach($students as $student){
            $fonts=Font::get();
            $template=$event->template;
            $studentAttachment=Pdf::loadView('admin.pdf.view',compact('fonts','student','template'));
            $attachmentPath=public_path('attachment');
            $fileName="{$student->name}.pdf";
            $filePath="{$attachmentPath}/{$fileName}";
            $studentAttachment->save($filePath);
            Attachment::create([
                'student_id'=>$student->id,
                'path'=>$filePath
            ]);
            Mail::to($student->email)->send(new StudentMail($student, $filePath));
        }
    }
}
