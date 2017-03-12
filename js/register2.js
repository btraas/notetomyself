


        $(document).ready(function() {

			document.forms[0].email.select();


			var error = false;
			$('#errormessage').hide();

            $("#submit").click(function() {
                resetFields();
                var emptyfields = $("input[value=]");
                if (emptyfields.size() > 0) {
					$('#errormessage').text("Missing required fields");
					error = true;
					$('#errormessage').show();

                    emptyfields.each(function() {
                        $(this).stop()
                            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                            .animate({ left: "0px" }, 100)
                            .addClass("required");
                    });
                };

				if($("#passwd").val().length < 6){
					$("#passwd").each(function() {
                        $(this).stop()
                            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                            .animate({ left: "0px" }, 100)
                            .addClass("required");
                    });

					if(error == false){
						$('#errormessage').text("Password must be 6+ characters long");
						error = true;
						$('#errormessage').show();
					}
				};

				if($("#passwd_conf").val() != $("#passwd").val()){
					if(error == false){
						$('#errormessage').text("no matchy passy");
						error = true;
						$('#errormessage').show();					
					}

					$("#passwd_conf").each(function(){
                        $(this).stop()
                            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                            .animate({ left: "0px" }, 100)
                            .addClass("required");
                    });
				};
				/*
				// check captcha
				if($("#code").val()){
					$('#errormessage').text("no matchy passy");
					error = true;
					$('#errormessage').show();					
				}*/

				if(error == true){
					$('#errormessage').show();
				}else{
					$('#errormessage').hide();
				}

				error = false;
	        });

				
			// give immediate email validation feedback
			$("#email").blur(function(){
				var email = $("#email").val();
				if(email != 0){
					if(isValidEmailAddress(email)){
						$("#validEmail").css({
							"background-image": "url('validYes.png')"
						});
					} else {
						$("#validEmail").css({
							"background-image": "url('validNo.png')"
						});
					}
				} else {
					$("#validEmail").css({
						"background-image": "none"
					});			
				}
			});


				
			// give immediate email validation feedback
			$("#email").keyup(function(){
				var email = $("#email").val();
				if(email != 0){
					if(isValidEmailAddress(email)){
						$("#validEmail").css({
							"background-image": "url('validYes.png')"
						});
					} else {
						$("#validEmail").css({
							"background-image": "url('validNo.png')"
						});
					}
				} else {
					$("#validEmail").css({
						"background-image": "none"
					});			
				}
			});


			// give immediate password validation feedback
			$("#passwd").keyup(function(){
				var pass = $("#passwd").val();
				if(pass != 0){
					// if the passwd_conf has already been filled in (first)
					// then check for a match here now too
					var passconf = $("#passwd_conf").val();
					if((passconf != 0 ) && (passconf.length >= 6)){
						if($("#passwd").val() == passconf){
							$("#validPass").css({"background-image": "url('validYes.png')"});
							$("#validPassConf").css({"background-image": "url('validYes.png')"});
						} else {
							$("#validPass").css({"background-image": "url('validNo.png')"});
							$("#validPassConf").css({"background-image": "url('validNo.png')"});
						}
					} else {
					
						if(pass.length >= 6){ // passconf has not been entered yet; ignore it here
							$("#validPass").css({
								"background-image": "url('validYes.png')"
							});
						} else {
							$("#validPass").css({
								"background-image": "url('validNo.png')"
							});
						}
					}
				} else {
					$("#validPass").css({
						"background-image": "none"
					});			
				}
				
			});







			// give immediate password-confirmation validation feedback
			$("#passwd_conf").keyup(function(){
				var pass      = $("#passwd").val();
				var pass_conf = $("#passwd_conf").val();
				if(pass != 0){
					if((pass == pass_conf) && (pass_conf.length >= 6)){
						$("#validPassConf").css({"background-image": "url('validYes.png')"});
//						$("#validPass").css({"background-image": "url('validYes.png')"});
					} else {
						$("#validPassConf").css({"background-image": "url('validNo.png')"});
//						$("#validPass").css({"background-image": "url('validNo.png')"});
					}
				} else {
					$("#validPassConf").css({
						"background-image": "none"
					});			
				}
			});


        });
        function resetFields() {
			error = false;
            $("input[type=text], input[type=password]").removeClass("required");
        }

		function isValidEmailAddress(emailAddress) {
 			//var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);


 			var pattern = new RegExp(/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/i);




			
 			return pattern.test(emailAddress);
		}



		function isFormDataValid(){
	
			var dataIsValid = true;
			var message     = "";
			$('#errormessage').hide();

			// is the email address valid?
			// is the password long enough?
			// is the password free of illegal characters?
			// does passwd_conf match the password?
			// is the captcha correct?
			// if so, the form data is valid so return true (else return false)

			if(dataIsValid == true)
			{
				if(!(isValidEmailAddress($("#email").val()))){
					dataIsValid = false;
					
					message = "Invalid email address: " + $("#email").val();
				}
			}
	
			if(dataIsValid == true)
			{
				if($("#passwd").val().length < 1){
					dataIsValid = false;
					message = "Password missing";
				}
			}


			if(dataIsValid == true)
			{
				if($("#passwd").val().length < 6){
					dataIsValid = false;
					message = "Password too short";
				}
			}



			if(dataIsValid == true)
			{
				if($("#passwd_conf").val().length < 1){
					dataIsValid = false;
					message = "Password confirmation missing";
				}
			}


			if(dataIsValid == true)
			{
				if($("#passwd").val() != $("#passwd_conf").val()){
					dataIsValid = false;
					message = "Passwords do not match";
				}
			}


			if(dataIsValid == true)
			{
				// no tags allowed
				if($("#passwd").val().indexOf('<') != -1){
					dataIsValid = false;
					message = "Ilegal character in password";
				}
			}

			if(dataIsValid == true)
			{
				if($("#passwd").val().indexOf('>') != -1){
					dataIsValid = false;
					message = "Ilegal character in password";
				}
			}


			if(dataIsValid == true)
			{			
				if($("#code").val().length != 4){
					dataIsValid = false;
					message = "Incorrect CAPTCHA code entered";
				}
			}		


/*
			if(!(isValidCaptchaCode($("#code").val()))){
				//dataIsValid = false;
				message = "Incorrect CAPTCHA code entered (maybe)";
			}

*/

/* pause
			if(dataIsValid == true)
			{
				isValidCaptchaCode($("#code").val());
					
				if(itsValid != "success")
				{
					dataIsValid = false;
	//				alert('finally true');
					message = "Incorrect CAPTCHA code entered";
				}
				itsValid = false; // reset it
			}
			
*/ 

			if(false == dataIsValid){
				$('#errormessage').text(message);
				//$('#errormessage').show('slow');	
				$('#errormessage').fadeIn(3000);

				// get a new captcha
				document.getElementById('captcha').src = './captcha/latest/securimage_show.php?' + Math.random();
			}else{
				var message     = "";
				$('#errormessage').hide();	
			}
/*
			if(dataIsValid == true){
				alert('valid');
			}else{
				alert('invalid');
			}
*/
			return dataIsValid;
		}


/*
var itsValid = false;

function isValidCaptchaCode(attempt){

//
 itsValid = $.ajax({
  url: "validatecaptcha.php?captcha_code=" + $("#code").val(),
  async: false
 }).responseText;


	//alert("VALIDATION TIME! " + itsValid);
}
*/
//

/*
	$.post("validatecaptcha.php", { 
		

		captcha_code: attempt}, 
         function(data){
			var isValid = false;
			if(data=="success"){
						
				//alert("CAPTCHA IS VALID: " + attempt);
				makeValid(true);
				return true;
			}else{
				//alert("CAPTCHA IS NOT VALID");
				makeValid(false);
				return false;
			}
		});	*/
	//}
/*

function makeValid(val)
{
	//alert("VALIDATION TIME! " + itsValid);
	itsValid = val;
}*/