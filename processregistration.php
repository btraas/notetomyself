<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

define("BASE_SITE", "http://note-to-myself.pricechecker.pro");

use PHPMailer\PHPMailer\PHPMailer;

require_once ("initdb.php");

function tryAgain() {
	return "Please try again to <a href=\"register2.php\">register</a> or <a href=\"index.php\">log in</a>";
}



function createAndGetKey($user, $pw) {
    $user = strtolower(trim($user));
    $conn = getConn();

    if(accountExists($user)) die('User exists!');

    $query = mysqli_prepare($conn, "INSERT INTO users (email, password_hash, tmp_hash) 
                                      VALUES (?,?,?)");

    $a = md5(time()/2);
    $b = md5(time()*1.7);
    $c = md5($user . $pw);
    $query->bind_param('sss', $user, sha1($pw), sha1($a . $b . $c ));
    $query->execute();

    $result = mysqli_query($conn, "SELECT tmp_hash FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    $row = $result->fetch_assoc();
    return $row['tmp_hash'];

}

function sendSignupEmail($user, $link) {
    date_default_timezone_set('America/Vancouver');

    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';

    $body = "Welcome to ".BASE_SITE.".


To finish signing up, please click this link: $link";

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

    $mail->Subject    = "Registration notice for note-to-myself.com for $user";

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $mail->IsHTML(false);
    $mail->CharSet = "text/plain; charset=UTF-8";
    $mail->Body = $body;
    
    
    $address = $user;
    $mail->AddAddress($address);


    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
    //    echo "Message sent!";
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

if($_POST['passwd'] != $_POST['passwd_conf']) {
    die("Passwords do not match. ".tryAgain());
}

if(strtolower($_POST['code']) != strtolower($_SESSION['securimage_code_value'])) {
    die("Invalid CAPTCHA code. " . tryAgain());
}

if(accountExists($_POST['email'])) {
    die("Account already exists for $_POST[email]. Did you forget your password? ".tryAgain());
}


$key = createAndGetKey($_POST['email'], $_POST['passwd']);

//$key = "2b4f9012dd37d8866bcccc420e29d23d";
$link = BASE_SITE . "/index.php?r=$key&e=$_POST[email]";

sendSignupEmail($_POST['email'], $link);

echo "
<body>


Thank you. <a href=\"/index.php?r=$key&e=$_POST[email]\">Finish signing up</a>.


<br>Thank you for registering. 


<br>An email has been sent to <span style=\"color:red;\">$_POST[email]</span>. 


<br>Please confirm your registration by clicking the link in your email. 


<br>Then you can <a href=\"index.php\">log in</a>. <span style=\"color:red;text-decoration:blink\">
    Alternatively, you can finish signing up <a href=\"$link\"></a></span>
<a href=\"$link\">now</a>.
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
