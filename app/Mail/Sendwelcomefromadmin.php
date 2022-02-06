<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Sendwelcomefromadmin extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $fullName;
    public $body;
	public $username;
	public $password;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_content = array()) {

        if (!empty($mail_content)) {
            $this->subject = "Welcome To Stealth!";//$mail_content['subject'];
            $this->fullName = $mail_content['fullName'];
            $this->body = $mail_content['body'];
			$this->username = $mail_content['username'];
			$this->password = $mail_content['password'];
        }
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $mailMsg = new MailMessage;
        $mailMsg->viewData = [
            'fullName' => $this->fullName,
            'body'     => $this->body,
			'username' => $this->username,
			'password' => $this->password
        ];

        return $mailMsg->subject($this->subject) 
                        ->line($this->subject);
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->markdown('emails.welcomemail');
		return $this->view('emails.welcomemailfromadmin')
                    ->with([
            'fullName' => $this->fullName,
            'body'     => $this->body,
			'username' => $this->username,
			'password' => $this->password
        ]);
    }
}
