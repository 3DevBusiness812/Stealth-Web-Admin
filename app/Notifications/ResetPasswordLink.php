<?php

/**
 * @file   ResetPasswordLink.php
 * @brief  This file is responsible for handling Reset Password Email Notification .
 * @date   Jun, 2019
 * @author ZCO Engineer
 * @copyright (c) 2019, ZCO
 */

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class ResetPasswordLink extends Notification
{
    use Queueable;

    protected $password;

    protected $fullname;

    /**
     * Create a new notification instance.
     *
     * @param string $password
     * @param string $fullname
     * @return void
     */
    public function __construct($password,$fullname)
    {
        $this->password = $password;
        $this->fullname = $fullname;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('NitcoLift: Reset password')
                                ->view('emails.reset_password_mail', [
                                       'fullname' => $this->fullname, 
                                       'password'=>$this->password]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
