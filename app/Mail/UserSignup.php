<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use function PHPUnit\Framework\assertGreaterThanOrEqual;

class UserSignup extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user=$user;
        $this->activation_token=$user->activation_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // send data with blade view to user email
        return $this->view('email.usersignup')->subject('registering to Hamed company')->with([
            'first_name'=>$this->user->first_name,
            'activation_token'=>$this->activation_token
        ]);
    }
}
