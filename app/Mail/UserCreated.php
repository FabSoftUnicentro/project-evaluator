<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $generatedPassword;

    /**
     * UserCreated constructor.
     * @param User $user
     * @param string $generatedPassword
     */
    public function __construct(User $user, string $generatedPassword)
    {
        $this->user = $user;
        $this->generatedPassword = $generatedPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Credenciais de Acesso')->markdown('emails.users.created');
    }
}
