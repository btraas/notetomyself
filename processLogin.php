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

$e = $_POST['email'];
$p = $_POST['passwd'];

if(!isset($_POST['email']) || !isset($_POST['passwd'])) {
	echo "Error logging in. Try <a href='index.php'>logging in</a> again or <a href='register2.php'>register</a> for a new account"; 
} elseif(!login($e, $p)) { 
	echo <<<EOF
Login error. Did you <a href='forgotpassword.php'>forget your password</a>? Please try again to <a href="register2.php">register</a> or <a href="index.php">log in</a>.
EOF;

}

function login($e, $p) {
	if(empty($e) || empty($p)) return false;
	return true;
}

?>


