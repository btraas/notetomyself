<?php
@session_start();
header("Content-type: image/png");
$_SESSION["captcha"] = substr(md5(time()),0,5);
$im = imagecreate(110, 30);
$white = imagecolorallocate($im, 244, 255, 255);
$red = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$size = $_SESSION["captcha"];
$text = "$size";
$font = 'comic.TTF';
imagettftext($im, 20, 0, 25, 20, $red, $font, $text);
imagettftext($im, 20, 0, 25, 20, $black, $font, $text);
imagepng($im);
imagedestroy($im);
?>
