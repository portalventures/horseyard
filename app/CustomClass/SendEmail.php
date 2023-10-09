<?php

namespace App\CustomClass;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class SendEmail
{
    public $fromMail;
    public $toMail;
    public $subject;
    public $body;

    public function sendMail()
    {
        $pass = env('SENDGRID_API_KEY'); // not the key, but the token
        $url = 'https://api.sendgrid.com/';

        $params = array(
            'to'        => $this->toMail,
            'subject'   => $this->subject,
            'html'      => $this->body,
            'from'      => $this->fromMail,
        );

        $request =  $url . 'api/mail.send.json';
        $headr = array();
        // set authorization header
        $headr[] = 'Authorization: Bearer ' . $pass;

        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // add authorization header
        curl_setopt($session, CURLOPT_HTTPHEADER, $headr);

        $response = curl_exec($session);
    }
}
