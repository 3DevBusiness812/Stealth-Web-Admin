<!DOCTYPE html>
<html>
<head>
	<title></title>



    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="images/favicon.ico" type="image/png">
    <title>Stealth</title> 
    <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style-stealth.css') }}" rel="stylesheet" type="text/css">	
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">

	<style type="text/css">

    .g-recaptcha {
        /*display: inline-block;*/
    }


#g-recaptcha-response {
    display: block !important;
    position: absolute;
    margin: -78px 0 0 0 !important;
    width: 302px !important;
    height: 76px !important;
    z-index: -999999;
    opacity: 0;
}

	</style>
	<script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body style="background: linear-gradient(to bottom right, #62BB46FF, #000000, #000000);">
	<div class="container">
		<div class="row">
			<div class="card" style="width: 35rem; margin: 50px auto;">
			  <div class="card-header" style="background:linear-gradient(62deg, rgba(0, 5, 0, 1) 0%, rgba(33, 123, 24, 1) 100%); text-align: center;">
			    <img src="{{ URL::asset('images/LogoSplash.png') }}" style="width: 50%;" />
			  </div>
			  <div class="card-boady">

		  		<div class="col-md-12" style="margin: 15px 0;">
					<form id="reset_password_form" action="{{ route('update_password') }}" method="post">
					  @csrf
					  <div class="form-group">
					    <label for="exampleInputEmail1">New Password</label>
					    <input type="password" class="form-control" name="password" id="newPassword">
					  </div>
					  <div class="form-group">
					    <label for="exampleInputPassword1">Confirm New Password</label>
					    <input type="password" class="form-control" name="confirm_password" id="checkPassword">
					  </div>
	  				  <div class="form-group" style="text-align: right;">

        				<!-- <div style="text-align: right;"> -->

		                    <input type="hidden" name="token" id="token" value="{{$token}}"/>
							<div class="g-recaptcha" data-sitekey="6LdehdcZAAAAALYul1ObfKxcDFFD6K0Xry4TBpaK"></div>
                            
                            <!-- <div class="g-recaptcha" data-sitekey="6LfOcNYZAAAAAMh3DsaiE5jZEHzAxN7O81BfEmIT"></div> -->
                            
                            <br/>
							<!-- <input type="submit" value="Submit" class="btn" style="background: #3fa21f; color: #fff;"> -->

						<!-- </div> -->

					  	<a id="submit_form" type="submit" class="btn" style="background: #3fa21f; color: black; font-weight: 500;">Submit</a>

				  	  </div>	
					</form>

				</div>


			  </div>
			</div>
		</div>
	</div>


    <div style="position: fixed; bottom: 0;" class="col-md-12"><p style="color: #fff; text-align: center; padding: 15px;">Copyright © <font color="green">Stealth Body Fitness</font></p></div>

    <script type="text/javascript">

        $("#submit_form").click(function(){

        	var success = checkPassword();
        	if(success == true){
        		
        		$("#reset_password_form").submit();
        	
        	}

        });

        function checkPassword(){
            var password = $("#newPassword").val();
            var check = $("#checkPassword").val();
            var token = $("#token").val();

            if (password)
            {
                if (password.length < 8)
                {
                    alert("The password must have at least 8 characters.");
                    return false;
                }
                else
                {
                    if (check)
                    {
                        if (password==check) 
                        {
                            if (token)
                            {
                                // alert("Your password has been reset successfully.\n" +
                                //     "Please login to your account with the new password.");


                                if(grecaptcha.getResponse() == '') {
                                    alert("Please complete the captcha.");
                                    //document.forms["entryForm"]["acceptAgrmt"].focus();
                                    return false;
                                }
                                else{
                                    return true;
                                }
                            }
                            else
                            {
                                alert("Invalid Password Reset Token.");
                                return false;
                            }
                        }
                        else 
                        {
                            alert("New Password and Confirm Password entries must match.");
                            return false;
                        }
                    }
                    else
                    {
                        alert("Enter Confirm Password.");
                        return false;
                    }
                }
            }
            else
            {
                alert("Enter New Password.");
                return false;
            }

        }

        window.onload = function() {
            var $recaptcha = document.querySelector('#g-recaptcha-response');

            if($recaptcha) {
                $recaptcha.setAttribute("required", "required");
            }
        };

    </script>

</body>
</html>