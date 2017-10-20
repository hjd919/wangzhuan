<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppleidFileMail extends Mailable
{
    use Queueable, SerializesModels;

    // public $viewVar = 'viewVar';
    protected $appleid_file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appleid_file)
    {
        $this->appleid_file = $appleid_file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.appleid_file')
            ->attach($this->appleid_file);
    }
}
