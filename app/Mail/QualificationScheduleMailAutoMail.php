<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QualificationScheduleMailAutoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $picName;
    public $documents;

    public function __construct($picName, $documents)
    {
        $this->picName = $picName;
        $this->documents = $documents;
    }

    public function build()
    {
        return $this->subject("Notifikasi Qualification")
                ->view('emails.qualificationschedule_automail');
    }

}
