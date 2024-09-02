<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArabicStudentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $student;
    public $path;
    public $course;
    public function __construct($student,$path,$course)
    {
        $this->student = $student;
        $this->path=$path;
        $this->course = $course;
    }
    public function build(){
        return $this->from('noreply@eeic.gov.eg', 'EEIC')
                    ->view('admin.mail.arabic')
                    ->subject('شهادة إتمام البرنامج التدريبي')
                    ->attach($this->path)
                    ->with([
                        'student' => $this->student,
                        'course'=>$this->course
                    ]);
    }
}
