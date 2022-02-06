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

        .line-break-p
        {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .text-muted
        {
            color: #6c757d!important;
        }

    </style>
</head>

<body style="font-family: Arial, Verdana; font-size: 16px; color: #787878; line-height: 20px; margin: 10px; background-color:#e4e4e4;line-height:26px;">
    
    <div style="max-width: 620px; margin: 0 auto; background-color:#ffffff;">
        
        <div style="padding:50px 25px; background: #1e6f16; text-align: center">
            
            <img src="http://34.220.13.185/Admin/public/images/logo.png" alt="Stealth" width="200" />

        </div>
        
        <div style="padding:40px 25px; border-bottom:1px solid #d8d8d8;">
            
            <ol style="padding-left: 0; margin: 0;">

                <li style="list-style-type: none;">

                    <div style="color: #232323; font-size: 16px; font-weight: bold; padding-bottom: 25px">
                        Hi {{$fullName}},
                    </div>
                
                </li>

            </ol>

            <ol style="padding-left: 0; margin: 0;">

                <li style="list-style-type: none;">
            
                    <p class="line-break-p" style="font-size: 16px;">
                        Welcome to Stealth! Your Stealth credentials have been created.
                    </p>

                    <p class="line-break-p" style="font-size: 16px;">
                        Here's what you need to do next to activate your account:
                    </p>

                </li>

            </ol>

            <ol type="1" style="padding-left: 30px; margin-bottom: 0; font-size: 16px;">
                <li>
                    <p class="line-break-p" style="line-height: 1.6;">
                        <strong>Download the Stealth Fitness App</strong> to your phone from the App Store or Google Play Store. You can use the direct links below or search Stealth Fitness in the App Store or Google Play Store
                    </p>
                </li>
            </ol>
        
            <ol style="padding-left: 0; margin: 0;">
                
                <li style="list-style-type:none;">

                <div class="line-break-p" style="margin-top: 35px;">
                    <a href="https://apps.apple.com/us/app/stealth-body-fitness/id1360949647" style=" margin-top: 20px; margin-bottom: 20px; font-size: 16px;text-decoration:none;">
                        iPhone Users Tap Here
                    </a>
                </div>

                <div class="line-break-p" style="margin-bottom: 35px;">
                    <a href="https://play.google.com/store/apps/details?id=com.stealth.stealthcorechallenge2&hi=en_US" style="margin-bottom: 20px; font-size: 16px;text-decoration:none;"
                        >Android Users Tap Here
                    </a>
                </div>

                </li>

            </ol>

            <ol start="2" type="2" style="padding-left: 30px;margin-top: 0; margin-bottom: 35px; font-size: 16px;">
                <li style="font-size: 16px;">
                    <p class="line-break-p"><strong>Launch the app</strong> and choose “<strong>Login</strong>” and enter the following credentials</p>
                </li>
            </ol>


            <ol style="padding-left: 0; margin: 0;">

                <li style="list-style-type: none;">

                    <p class="line-break-p">
                        <span style="color: #232323; font-size: 16px;">
                            Username:<a style="text-decoration: none;" href="mailto:{{ $username }}"><strong> {{ $username }}</strong></a>
                        </span>
                    </p>

                    @if($password != '')

                    <p class="line-break-p">
                        <span style="color: #232323; font-size: 16px;">
                            Password:<strong> gameyourcore</strong>
                        </span>
                    </p>
                        
                    @endif

                    <p class="line-break-p" style="margin-bottom: 1px; font-size: 14px;">
                        <i>
                            Please be sure not to capitalize any letter of the password. Once you successfully login, you will be prompted to change this default password.
                        </i>
                    </p>

                </li>

            </ol>

            <ol style="padding-left: 0; margin: 0;">

                <li style="list-style-type: none;">

                    <p style="font-size: 16px; margin-top: 3px; margin-bottom: 35px;">
                        <b>Game Your Core and Have Fun!</b>
                    </p>

                    <p class="text-muted" style="color: #626262; font-weight:normal; margin:35px 0;font-size:16px; line-height:20px;">
                            Best Regards,
                            <br>
                            Stealth Team
                    </p>

                    <p class="line-break-p text-muted" style="font-weight:normal;font-size:16px; line-height:20px;">
                            This is an autogenerated email. Please contact <a style="text-decoration: none;" href="mailto:support@gameyourcore.com">support@gameyourcore.com</a> with any problems
                    </p>

                </li>

            </ol>

        </div>

    </div>
   
</body>

</html>
