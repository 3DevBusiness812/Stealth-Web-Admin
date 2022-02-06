@extends('layouts.app')
@section('content')

        <div class="clearfix"></div>
        
        {!! Form::open( array('id' => 'settings','class' => 'form', 'method' => 'post')) !!}
                  {{ csrf_field() }}

               <div class="container-fluid mr-top pRL0">
                   
                   <div class="completed_response_box shw_message_box completedResponse"></div>  

       <div class="page-wrapper pd25">
           
           <div class="col-lg-4">
                   <div class="form-group">
                       <h5>Reset Password</h5>
                                <label for="exampleInputPassword1">Current Password</label>
                                <input type="password" class="form-control form-right" value="" id="currentPass" name="currentPass" placeholder="Password" autocomplete="off" /> 
                                 @if ($errors->has('currentPass'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('currentPass') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">New Password</label>   
                                <input type="password" class="form-control form-right" value="" id="password" name="password" placeholder="Password" autocomplete="off" />                                
                            </div>
               <div class="form-group">
                                <label for="exampleInputPassword1">Confirm Password</label>   
                                <input type="password" class="form-control form-right" value="" id="confirmPass" name="confirmPass" placeholder="Password" autocomplete="off" />                         
                            </div>
               
               </div></div>
        </div>

        <button type="submit" class="btn login-btn float-right btn-green-b">RESET PASSWORD</button>
        {!! Form::close() !!}

 @endsection
@push('scripts') 
<script src="{{asset('admin/js/users.js')}}"></script>

@endpush