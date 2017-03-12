







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="pencil.ico" />

    <title>Note to Myself - Reset Password</title>
    <link type="text/css" href="css/register2.css" rel="stylesheet" media="screen"></link>
    <script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/login2.js"></script>

</head>
<body>

    <h1>Reset Your Password</h1>

	<p>
		Type your email address in the text box below. A new password will be sent to your email address.
	</p>

	<form action="processpasswordreminder.php" method="post">
<!--    <p>Demo for <a href="http://www.jankoatwarpspeed.com/post/2009/09/16/Animate-validation-feedback-using-jQuery.aspx">Animate validation feedback using jQuery</a></p>
    <h2><img src="header.png" alt="Account information" /></h2> -->
    <ul>
        <!--<li class="first">
            <h3>Your Name</h3>
            <p>

                <input type="text" value="First and Last name" id="name" name="name" /></p>
        </li>-->
        <li>
            <h3>Email address<span id="validEmail"></span></h3>
            <p>
                <input type="text" name="email" id="email" tabindex="1"  />
						
							
				</p>
        </li>

       




        <li class="last">
            <p>
				<!--<a id="signup" href="#"> -->
					<input type="submit" value="Email new password" alt="password-reminder button" style="vertical-align:middle;" tabindex="5" />
				<!--</a>-->
				</p>
		</li>
		</ul>

	</form>
</body>
</html>
