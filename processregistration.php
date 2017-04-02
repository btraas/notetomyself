<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once ("initdb.php");

function tryAgain() {
	return "Please try again to <a href=\"register2.php\">register</a> or <a href=\"index.php\">log in</a>";
}

function accountExists($user) {
    $user = strtolower(trim($user));
    $conn = getConn();


    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    return mysqli_num_rows($result) > 0;
}

function sendSignupEmail($user) {
    date_default_timezone_set('America/Vancouver');

    echo "sending email to $user";
    require_once __DIR__ . '/vendor/autoload.php';
    //require 'PHPMailerAutoload.php';
    //require_once('PHPMailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

    $mail             = new PHPMailer();

    $body             = "gdssdh";
//$body             = eregi_replace("[\]",'',$body);

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
    $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "btraasdev";      // GMAIL username
    $mail->Password   = "btraasdev1";            // GMAIL password

    $mail->SetFrom('btraas@gmail.com', '');

    //$mail->AddReplyTo("user2@gmail.com', 'First Last");

    $mail->Subject    = "Note To Myself password";

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $mail->MsgHTML($body);

    $address = $user;
    $mail->AddAddress($address);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

    echo "sending!";
    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}


session_start();
include_once('captcha/latest/securimage.php');
$securimage = new Securimage();

//if ($securimage->check($_POST['code']) == false) echo 'failed';

//print_r($_SESSION);

if(empty($_SESSION['securimage_code_value']) && false) {
	for($i=0;$i<15;$i++) echo "\n";
	die("oops" . tryAgain());
}

if(empty($_POST['email'])) {
	die("Missing email address. ".tryAgain());
}

if(empty($_POST['passwd'])) {
	die("Missing password. ".tryAgain());
}

if(empty($_POST['passwd_conf'])) {
	die("Missing password conirmation. ".tryAgain());
}

if(empty($_POST['code'])) {
	die("Missing captcha code. ".tryAgain());
}


if(!preg_match("/^\S+@[0-9a-z]+\.[a-z]+$/i", $_POST['email'])) {
	die("Email address ($_POST[email]) does not pass filter validation.".tryAgain());
}

if(strtolower($_POST['code']) != strtolower($_SESSION['securimage_code_value'])) {
    die("Invalid CAPTCHA code. " . tryAgain());
}

if(accountExists($_POST['email'])) {
    die("Account already exists for $_POST[email]. Did you forget your password? ".tryAgain());
}

$key = "2b4f9012dd37d8866bcccc420e29d23d";

sendSignupEmail($_POST['email']);

echo "
<body>


Thank you. <a href=\"/index.php?r=$key&e=$_POST[email]\">Finish signing up</a>.


<br>Thank you for registering. 


<br>An email has been sent to <span style=\"color:red;\">$_POST[email]</span>. 


<br>Please confirm your registration by clicking the link in your email. 


<br>Then you can <a href=\"index.php\">log in</a>. <span style=\"color:red;text-decoration:blink\">Alternatively, you can finish signing up <a href=\"/index.php?r=$key&e=$_POST[email]\"></a></span>
<a href=\"/index.php?r=$key&e=$_POST[email]\">now</a>.
</body>
";
//empty for each, then validate each?

//(use isset)
// no email

// (empty) missing password confirmation.
// (empty) no captcha value
// invalid email





//echo "code in session, checking...";
?>
