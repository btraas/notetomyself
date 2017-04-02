<?php
ob_start();
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <link rel="shortcut icon" href="pencil.ico">

    <title>Note to Myself - Log in</title>
    <link type="text/css" href="css/register2.css" rel="stylesheet" media="screen">
    <script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/login2.js"></script>

</head>
<body>
<?php
if(!isset($_SESSION['user'])){
    die("<p><a href=\"index.php\">Log in</a> or <a href=\"register2.php\">register</a> before logging out.</p>");
}

echo "<h2>$_SESSION[user] is now logged out. Thank you.</h2><p><a href=\"index.php\">Log in</a> again.</p>";

$_SESSION = array();


if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}


session_destroy();
ob_end_flush();
