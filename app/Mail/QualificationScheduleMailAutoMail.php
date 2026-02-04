<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QualificationScheduleMailAutoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $links;

    public function __construct($links)
    {
        $this->links = $links;
    }

    public function build()
    {
        return $this->subject("Notifikasi Qualification")
                ->view('emails.qualificationschedule_automail');
    }

}
