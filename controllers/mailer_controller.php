<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
namespace CitInterests\mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'assets/PHPMailer/src/Exception.php';
require 'assets/PHPMailer/src/PHPMailer.php';
require 'assets/PHPMailer/src/SMTP.php';

class Mailer
{
    public static function SendMail($subject, $body, $recipient, $user_firstname, $user_lastname)
    {
        try {
            //Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);
            /* Use SMTP. */
            $mail->isSMTP();
            $mail->Mailer = "smtp";

            $mail->SMTPDebug = 1;
            /* Set authentication. */
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            /* SMTP port. */
            $mail->Port = 587;
            /* Google (Gmail) SMTP server. */
            $mail->Host = 'smtp.gmail.com';
            $mail->Username = "contact.citinterests@gmail.com";
            $mail->Password = "CitInterests_2021";

            $mail->isHTML(true);
            /* Add a recipient. */
            $mail->addAddress($recipient, $user_firstname . ' ' . $user_lastname);
            /* Set the mail sender. */
            $mail->setFrom('support-citinterests@gmail.com', 'Support CitInterests');
            /* Set the subject. */
            $mail->Subject = $subject;
            /* Set the mail message body. */
            $mail->Body = $body;

            /* Finally send the mail. */
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
