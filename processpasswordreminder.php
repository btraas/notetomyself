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

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL);

function sendResetEmail($e) {
	// todo this
}

$e = $_POST['email'];

if(sendResetEmail($e)) {
	echo "sent";
} else {
	
	echo "No record for $e. Please <a href='register2.php'>register</a>.";
}
