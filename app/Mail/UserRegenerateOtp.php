<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class UserRegenerateOtp extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('emailtes@gmail.com')
                    ->subject('Kode OTP Baru')
                    ->view('mail.send_regenerate_code')
                    ->with([
                        'otpCode' => $this->user->otpCode->code
                    ]);
    }
}
