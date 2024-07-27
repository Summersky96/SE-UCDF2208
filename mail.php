<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';

function send_mail($recipient,$subject,$message)
{

    $mail = new PHPMailer();
    $mail ->IsSMTP();

    $mail ->SMTPDebug = 0;
    $mail ->SMTPAuth = true;
    $mail ->SMTPSecure = "tls";
    $mail ->Port = 587;
    $mail ->Host = "smtp.gmail.com";
    $mail ->Username = "jinnxiang08@gmail.com";
    $mail ->Password = "rwcb ervx onyr hrlo";

    $mail ->IsHTML(true);
    $mail ->AddAddress($recipient,"user");
    $mail ->SetFrom("jinnxiang08@gmail.com", "AutoMate");
    $mail ->Subject = $subject;
    $content = $message;

    $mail ->msgHTML($content);
    if(!$mail->send()){
        //echo "Error while sending Email.";
        //echo "<pre>";
        //var_dump($mail);
        return false;
    } else {
        //echo "Email sent successfully";
        return true;
    }

}

?>