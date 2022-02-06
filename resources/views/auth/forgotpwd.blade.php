<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stealth Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/skin-white.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/admin.css')}}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1 class="text-uppercase m-0">forgot password</h1></div>

                <div class="card-body">
<form method="post" action="{{ route('admin.resetpwd') }}" id="forgot_password">
@csrf
    <div class="rightBox">
      
       <div class="formBox forgotPass position-relative">
        @if(session()->has('message'))
                <div class="alert alert-success" id="resetsuccessmessage">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="form-group position-relative">
            <input class="user" type="text" placeholder="Email" name="forgot_email" id="forgot_email"  >
            @if ($errors->has('forgot_email'))
                <div class="error-show login-error-msg">{{ $errors->first('forgot_email') }}</div>
            @endif
            <button type="submit" class="btn btn-primary text-center text-uppercase" title="Submit Password">submit</button>
            @if ($errors->has('emailerror'))
                <div class="error-show login-error-msg">{{ $errors->first('emailerror') }}</div>
            @endif
        </div>
        </div>
        <div class="btmLink text-center"><a class="back" href="{{ route('admin.login')}}">Back to Login</a>
        
    </div>
</form>
</div>
            </div>
        </div>
    </div>
</div>

 <script type="text/javascript">

    $(document).ready(function(){
        $('#forgot_password').validate({  
            onfocusout: function (element) {
                $(element).valid();
            },
            rules: {
                forgot_email: {
                    required: true,
                    email: true,
                }
            },
            messages: {
                forgot_email: {
                    required:'Enter Email ID.',
                    email:'Enter a valid Email ID.',
                }
            },
            errorPlacement: function (error, element) {            
                error.insertAfter(element);
            },
        });
    }); 
    
 </script> 
