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

                    
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert" style="text-align: center;">
                          {{ Session::get('message') }}
                        </div>
                    @elseif (Session::has('error_message'))
                        <div class="alert alert-danger" role="alert" style="text-align: center;">
                            {{ Session::get('error_message') }}
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert" style="text-align: center;">
                            Page expired
                        </div>
                    @endif


                </div>


              </div>
            </div>

        </div>
    </div>
<div style="position: fixed; bottom: 0;" class="col-md-12"><p style="color: #fff; text-align: center; padding: 15px;">Copyright © <font color="green">Stealth Body Fitness</font></p></div>
</body>
</html>