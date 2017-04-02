<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="shortcut icon" href="pencil.ico" />

    <title>Note to Myself - Log in</title>
    <link type="text/css" href="css/register2.css" rel="stylesheet" media="screen"></link>
    <script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/login2.js"></script>

</head>
<body>

<?php 
//print_r($_POST);

define("BASE_SITE", "http://note-to-myself.pricechecker.pro");
require_once ("initdb.php");


$e = $_POST['email'];
$p = $_POST['passwd'];

if(!isset($_POST['email']) || !isset($_POST['passwd'])) {
	echo "Error logging in. Try <a href='index.php'>logging in</a> again or <a href='register2.php'>register</a> for a new account"; 
} elseif(!login($e, $p)) { 
	die("Login error. Did you <a href='forgotpassword.php'>forget your password</a>?
        Please try again to <a href=\"register2.php\">register</a> or <a href=\"index.php\">log in</a>.");

}

$confirmHash = getConfirmHash($_POST['email']);

if(!empty($confirmHash)) {
    $confirmLink = BASE_SITE . "/index.php?r=$confirmHash&e=$_POST[email]";
    die("You need to confirm your registration before you can log in. Check your email ($e).<br>
Thank you for registering.<br>
              An email has been sent to <span style=\"color:red;\">$e</span><br>
    Please confirm your registration by clicking the link in your email.<br>
    Then you can <a href=\"index.php\">log in</a>. 
    <span style=\"color:red;\">Alternatively, you can finish signing up <a href=\"$confirmLink\">now</a>.");
}

header('Location: notes.php');
exit;

function login($e, $p) {
	if(empty($e) || empty($p)) return false;
	//return true;


    $user = strtolower(trim($e));
    $conn = getConn();

    if(!accountExists($user)) return false;

    $result = mysqli_query($conn, "SELECT password_hash FROM users WHERE email = '$user'") or
    die(mysqli_error($conn));

    $row = $result->fetch_assoc();
    if($row['password_hash'] != sha1($p)) return false;

    session_start();
    $_SESSION['user'] = $user;
    return true;
}

?>


