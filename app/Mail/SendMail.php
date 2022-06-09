<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $total;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        $total
    ) {
        $this->user = $user;
        $this->total = $total;
        $this->queue = 'report';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.sendmail')
            ->with(['user' => $this->user, 'orders' => $this->total]);
    }
}
