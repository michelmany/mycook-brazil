<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    private $subjectField;
    private $sender_mail;
    private $sender_name;
    private $messageField;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subjectField, $sender_mail, $sender_name, $messageField)
    {
        $this->subjectField = $subjectField;
        $this->sender_mail = $sender_mail;
        $this->sender_name = $sender_name;
        $this->messageField = $messageField;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(config('mail.contact'))
            ->from($this->sender_mail)
            ->subject($this->subjectField)
            ->markdown('emails.contact_form', [
                'subjectField'=>$this->subjectField,
                'sender_name'=>$this->sender_name,
                'sender_mail'=>$this->sender_mail,
                'messageField'=>$this->messageField
            ]);
    }
}
