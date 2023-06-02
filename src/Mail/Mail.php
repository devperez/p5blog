<?php

namespace David\Blogpro\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    /***
     * @param string $name
     * @param string $email
     * @param string $message
     * @return boolean true if mail is sent
     */


    public function send(string $name, string $email, string $message): bool
    {
        $mail = new PHPMailer(true);
        $message = wordwrap($message, 70);

        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['HOST'];
            $mail->Port = $_ENV['PORT'];

            $mail->setFrom($email, $name);
            $mail->addAddress($_ENV['ADDRESS']);

            $mail->isHTML(true);
            $mail->Subject = $_ENV['SUBJECT'];
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Message non envoyé : {$mail->ErrorInfo}";
        }
    }
}
