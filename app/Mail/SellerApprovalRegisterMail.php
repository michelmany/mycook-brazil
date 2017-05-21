<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SellerApprovalRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    private $active;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(bool $active)
    {
        $this->active = $active;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmação de aprovação')
            ->markdown('emails.seller_approval', [
                'active' => $this->active
            ]);
    }
}
