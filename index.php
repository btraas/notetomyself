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

    <h1>Log in</h1>

	<form action="processLogin.php" method="post" onsubmit="return isFormDataValid();">
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
        <li>

            <h3 title="6+ characters">Password<span id="validPass"></span></h3>
            <p>
                <input type="password" id="passwd" name="passwd" title="6+ characters" tabindex="2" /></p>
        </li>
       




        <li class="last">
            <p>
				<!--<a id="signup" href="#"> -->
					<input type="image" id="submit" src="login2.png" alt="register button" style="vertical-align:middle;" tabindex="5" />
				<!--</a>-->
				</p>
		</li>
		
		<li>
				<p><a href="register2.php">Register</a> | <a href="forgotpassword.php">Forgot password</a>
				</p>
        </li>



        <li id="errormessage" style="color:red;"></li>
		<li><a href="http://twitter.com/#!/notes_myself">Twitter</a></li>
    </ul>

	</form>
</body>
</html>
