<?php
session_start();
include_once('captcha/latest/securimage.php');
$securimage = new Securimage();

//if ($securimage->check($_POST['code']) == false) echo 'failed';

if(empty($_SESSION['securimage_code_disp'])) {
	for($i=0;$i<15;$i++) echo "\n";
	echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
oopsPlease try again to <a href="register2.php">register</a> or <a href="index.php">log in</a>
EOF;
}



echo "code in session, checking...";
?>
