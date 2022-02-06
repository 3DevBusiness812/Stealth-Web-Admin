<!DOCTYPE html>
<html lang="en">
<head>
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

</head>
<body>


<form method="post" action="{{route('admin.submitLogin')}}">
                        @csrf
                       <div class="col-12">     
                <div class="row">
                    <div class="col-lg-6 log-left"><div class="logo"><img src="{{ URL::asset('images/logo.png') }}" />
                        </div>
</div>
                    <div class="col-lg-6 log-right">

                        <div class="fieldwrap form-login">
                          
                            <h1>LOGIN</h1>
                            <div class="form-group ">
                                <label for="exampleInputPassword1">{{ __('Email') }}</label>
                                <input id="useremail" type="text" autocapitalize="none" class="form-control @error('useremail') is-invalid @enderror" name="useremail" >
                                @error('useremail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">{{ __('Password') }}</label>
   
                                <input id="password" type="password" autocapitalize="none" class="form-control @error('password') is-invalid @enderror" name="password" >
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
							@if ($errors->has('error'))
                            <div class="error-show textboxError pl-3" style="color:red">{{ $errors->first('error') }}</div>
							@endif
                            <div class="form-group ">
                            	<button  type="submit" class="btn login-btn btn-green-b loginBtn" >LOGIN</button>
							                                
                                
                                <br clear="all" />
                            </div>


                        </div>

                    </div>
                    
                </div>
              </div>          
</form>

@include('layouts.footer')