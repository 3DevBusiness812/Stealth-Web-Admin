<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Stealth</title>
    <style type="text/css">
        p {
            margin-bottom: 0;
            color: #333;
            line-height: 20px;

        }

        li {
            line-height: 20px;
            color: #333;
        }

    </style>
</head>

<body style="font-family: Arial, Verdana; font-size: 16px; color: #787878; line-height: 20px; margin: 10px; background-color:#e4e4e4;line-height:26px;">
    <div style="max-width: 620px; margin: 0 auto; background-color:#ffffff;">
        <div style="padding:50px 25px; background: #1e6f16; text-align: center">
            <img src="http://34.220.13.185/Admin/public/images/logo.png" alt="Stealth" width="200" />

        </div>
        <div style="padding:40px 25px; border-bottom:1px solid #d8d8d8;">
            <span style="color: #232323; font-size: 16px; font-weight: bold; padding-bottom: 25px">Hi {{ $fullName }},</span>

<br>
<br>
            <p>Welcome to Stealth Premium!</p> 

<br>
<br>
<p>You now have access to the complete library of Stealth Premium Games.</p>
<br>
<p>You will also receive a new Stealth Game at the end of every month, as well as complete access to the Premium Games that are already released. </p>


            <br>



            <p>Here's what you need to do next to activate your account: </p>

            <ol type="1" style="padding-left: 15px; margin-bottom: 25px; font-size: 16px;">
                <li>Download the Stealth Body Fitness App to your phone from the App Store or Google Play Store. You can use the direct links below or search Stealth Body Fitness in the App Store or Google Play Store. </li>
				<br>
                <a href="https://apps.apple.com/us/app/stealth-body-fitness/id1360949647" style=" margin-top: 20px; margin-bottom: 20px;">iPhone Users Tap Here</a>
<br>               
			   <a href="https://play.google.com/store/apps/details?id=com.stealth.stealthcorechallenge2&hi=en_US" style="margin-bottom: 20px; ">Android Users Tap Here</a>
<br><br>
                <li>Login to your Stealth Premium account using the following   Credentials:</li>
                
				<p>
                    <span style="color: #232323; font-size: 16px; font-weight: bold; ">Username: {{ $username }}</span>
                </p>
				@if($password != '')
					<p>
						<span style="color: #232323; font-size: 16px; font-weight: bold; padding-bottom: 25px">Password: gameyourcore</span>
					</p>
					
					<p style="font-style: italic; font-size: 14px;">Please be sure not to capitalize any letter of the password. Once you successfully login, you will be prompted to change this default password.</p>
				@endif
                <br>
                <li>That's it! After you login, tap Stealth Games & Workouts to view all of the premium games you have access to.</li>



            </ol>
			
            <p ><b>Game Your Core and Have Fun!</b></p>
			<br>
			<p style="color: #626262; font-weight:normal; margin:0;font-size:16px; line-height:20px;">

                If you have any issues, please email <a href="mailto:support@gameyourcore.com" target="_top" style="color: #1e6f16">support@gameyourcore.com</a> with a short description. Please include your phone model and mention that you are a premium subscriber. </p>
        </div>

    </div>
   
</body>

</html>
