<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminOrderPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $address)
    {
        $this->order = $order;
        $this->address = $address;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Novo pedido de cliente')
            ->markdown('emails.admin_order_paid');
    }
}
