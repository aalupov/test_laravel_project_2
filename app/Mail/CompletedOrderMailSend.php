<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompletedOrderMailSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The completedOrderMailSend object instance.
     *
     * @var completedOrderMailSend
     */
    public $completedOrderMailSend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($completedOrderMailSend)
    {
        $this->completedOrderMailSend = $completedOrderMailSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->completedOrderMailSend->sender_email, $this->completedOrderMailSend->sender_name)
            ->subject('The order #' . $this->completedOrderMailSend->order->id . ' has been completed')
            ->view('mail.completed');
    }
}
