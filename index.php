<?php
//i get the username in url
$url = $_SERVER['REQUEST_URI'];

//visitor the url i get the name
$visitor = urldecode($url);


//im split string then i got exact user name
$userName = substr($visitor, 9);



//i stroe the file in user given the name in visitor folder
$filepath = "visitor/$userName.txt";

// i get the now time in date function
$dateAndtime = date('H:i:s');

// and i'm open the file and i write user visited time
$system = fopen($filepath,"a");
fwrite($system,"\n visited $userName at $dateAndtime");
fclose($system);




// i'm scan the visitor dir and all file store in the visitor dir
$allUserEntry = scandir('visitor');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'd5624c5cbc4bac';                     //SMTP username
    $mail->Password   = '23495e697547c7';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('parasuramanadckap@gmail.com',"parasuraman");
    $mail->addAddress('kishorekumarcdckap@gmail.com', 'kishorekumar');     //Add a recipient
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments

    // i loop the all user entry and i got history of users
    for($i=2;$i<count($allUserEntry);$i++){
        // i send the all user text file in addAttachment function
        $mail->addAttachment("visitor/$allUserEntry[$i]");
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = "hello <b>$userName</b>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}





