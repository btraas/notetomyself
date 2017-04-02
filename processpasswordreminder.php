<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="pencil.ico" />

    <title>Note to Myself - Reset Password</title>
    <link type="text/css" href="css/register2.css" rel="stylesheet" media="screen"></link>
    <script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/login2.js"></script>

<body>
<?php

//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;

require_once 'initdb.php';

// email reset with link bug
function sendResetEmail($e, $pw) {
    date_default_timezone_set('America/Vancouver');

    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';

    $hash = md5(time());
    $datetime = date('l, F d, Y at h:iA');
    $body = "From admin@note-to-myself.com on $datetime: \n\n

Welcome to ".BASE_SITE.". YOUR NEW PASSWORD IS $pw. Please keep this email or write this down.


To log in again, please click this link: ".BASE_SITE."/n2m/index.php?r=$hash&e=$e";

    $mail             = new PHPMailer();

    //$body             = "gdssdh";
//$body             = eregi_replace("[\]",'',$body);

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "btraasdev";      // GMAIL username
    $mail->Password   = "btraasdev1";            // GMAIL password

    $mail->SetFrom('btraas@gmail.com', 'note-to-myself admin');

    //$mail->AddReplyTo("user2@gmail.com', 'First Last");

    $mail->Subject    = "Password reset notice for note-to-myself.pricechecker.pro";

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $mail->IsHTML(false);
    $mail->CharSet = "text/plain; charset=UTF-8";
    $mail->Body = $body;


    $address = $e;
    $mail->AddAddress($address);


    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        //    echo "Message sent!";
    }
}

$e = strtolower(trim($_POST['email']));

$new = substr(md5(time()), 8, 4);

if(accountExists($e)) {
    updateUserStrings($e, ['password_hash'=>$new]);
    sendResetEmail($e, $new);
	sent($e, $new);
} else {
	echo "No record for $e. Please <a href='register2.php'>register</a>.";
}

function sent($email, $pw) {
    echo <<<EOF

<body><h1>Your new password is $pw</h1>


<br>Your password has been reset. 


<br>An email may have been sent to <span style="color:red;">$email</span>. 


<br>Please use your new password from now on. 


<br>Then you can <a href="index.php">log in</a>.</body>


EOF;

}