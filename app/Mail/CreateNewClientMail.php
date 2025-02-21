<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class CreateNewClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        $clientName = $this->data['first_name'].' '.$this->data['last_name'];
        $userName = $this->data['email'];
        $password = $this->data['client_password'];
        $subject = 'Welcome '.$clientName.' to '.getAppName();
        $client_id = Crypt::encrypt($this->data['user_id']);

        return $this->view('emails.create_new_client_mail',
            compact('clientName', 'userName', 'password','client_id'))
            ->markdown('emails.create_new_client_mail')
            ->subject($subject);
    }
}
