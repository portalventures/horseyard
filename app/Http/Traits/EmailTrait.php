<?php

namespace App\Http\Traits;

trait EmailTrait
{
  public function sendMail($from, $to, $subj, $mbody)
  {
    $email = new \SendGrid\Mail\Mail();
    if (!empty($from)) {
      $email->setFrom($from, $from);
    } else {
      $email->setFrom(getenv('SENDGRID_SERDER_ADDRESS'), getenv('SENDGRID_SERDER_NAME'));
    }

    if (!empty($subj)) {
      $email->setSubject($subj);
    } else {
      $email->setSubject("Email from : " . config('app.name'));
    }

    if (!empty($to)) {
      $email->addTo($to, $to);
    } else {
      return back()->with('error', 'To Address is Empty or Null');
    }

    if (!empty($mbody)) {
      $email->addContent("text/html", $mbody);
    } else {
      return back()->with('error', 'Message body can not be empty or Null');
    }

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    try {
      $response = $sendgrid->send($email);
      return $response;
    } catch (\Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
  }

  public function testMail()
  {
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("developer@inuscg.com", "INUSCG Developer");
    $email->setSubject("Sending with SendGrid is Fun");
    $email->addTo("sanjay.agrawal@inuscg.com", "Sanjay Agrawal");
    $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $email->addContent(
        "text/html",
        "<strong>and easy to do anywhere, even with PHP</strong>"
    );
    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (\Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
  }
}
