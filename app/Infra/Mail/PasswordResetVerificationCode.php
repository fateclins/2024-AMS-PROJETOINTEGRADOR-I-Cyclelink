<?php
namespace App\Infra\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $verificationCode
     * @param $user
     */
    public function __construct($verificationCode, $user)
    {
        $this->verificationCode = $verificationCode;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emailVerification')
            ->subject('Password Reset Verification Code')
            ->with([
                'verificationCode' => $this->verificationCode,
                'user' => $this->user,
            ]);
    }
}
?>
