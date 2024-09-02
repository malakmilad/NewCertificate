<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $student;
    public $path;

    public function __construct($student,$path)
    {
        $this->student = $student;
        $this->path=$path;
    }
    public function build(){
        return $this->from('noreply@eeic.gov.eg', 'EEIC')
                    ->view('admin.pdf.mail')
                    ->subject('Your PDF Document')
                    ->attach($this->path)
                    ->with([
                        'student' => $this->student,
                    ]);
    }
}
