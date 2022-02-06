@extends('layouts.app')
@section('content')
<div class="clearfix"></div>
{!! Form::open( array('id' => 'editformPremiumuser','class' => 'form', 'method' => 'post')) !!}
    
               <div class="container-fluid mr-top">
               <div class="completed_response_box shw_message_box completedResponse"></div>     
       <div class="page-wrapper">
           <div class="row user-content">
               <input type="hidden" name="userId" value="{{isset($users->userid) ? $users->userid:''}}"/>
               <input type="hidden" name="useremail" value="{{isset($users->useremail) ? $users->useremail:''}}"/>
               <div class="col-lg-4">
                   <div class="user-detail">
               <img src="{{ asset('images/icn_userprofile.png')}}"> <p>{{isset($users->firstname) ? $users->firstname:''}} {{isset($users->lastname)?$users->lastname:''}}</p></div>
                   <div class="user-detail">
               <img src="{{ asset('images/icn_mail.png')}}"> <p>{{isset($users->useremail) ? $users->useremail:''}}</p></div>
                   <div class="user-detail">
               <img src="{{ asset('images/icn_phone.png')}}"> <p>{{isset($users->mobile_no) ? $users->mobile_no:''}}</p></div>
               </div>
               
               
               <div class="col-lg-3">
               <div class="user-detail">
               <img src="{{ asset('images/icn_gender.png')}}"> <p>@if(isset($users->gender)&&$users->gender=='m') Male @elseif(isset($users->gender)&&$users->gender=='f') Female @endif</p></div>
                   <div class="user-detail">
               <img src="{{ asset('images/icn_date.png')}}"> <p>{{isset($users->created) ? $users->created:''}}</p></div>
                   <div class="user-detail">
               <img src="{{ asset('images/icn_nation.png')}}"> <p>@if(isset($users->country) && $users->country!='') <img @if($users->country!='ZZ') class="flag-dimension" @endif; src="{{ asset('images/Flags').'/'.$users->country.'.png' }}"> @else <img src="{{ asset('images/Flags/ZZ.png')}}"> @endif</p></div>
               </div>
               
               <div class="col-lg-5">
               <div class="user-detail">
               <img src="{{ asset('images/icn_trolly.png')}}"> <p><span>Purchased from </span> 
                    <?php if( isset($users->purchased_from) && $users->purchased_from != '' ) {
                                foreach ($arrPurchasedFrom as $key => $purchasedFrom) {
                                    if ($key == $users->purchased_from) echo $purchasedFrom;
                                }
                          } else
                              echo '--';
                    ?>
               </p></div>
               @if((isset($users->is_non_expiring)) && ($users->is_non_expiring != 1))
                <div class="user-detail col-7">
                <div class="row"><p class="w-100">Expiration Date</p>
                <div class="date-form">
                <input type="hidden" value="{{date('Y-m-d', strtotime('tomorrow'))}}" id="tomorrow">
                <span class="fa fa-calendar calendar-input"></span>
               
                <input type="text" class="form-control datepicker" id="expiryDate" name="expiryDate"  value="{{isset($users->expiry) ? $users->expiry:''}}"  readonly>
               
                <!-- <div class="date-btn"><p>Renew</p><img src="{{ asset('images/icn_renew.png')}}"></div>   -->
                </div>
                </div>
                </div>
                @endif
                   

                  
                <div class="user-detail"> 
                <div class="pretty p-svg p-curve checkbox">
                            <input type="checkbox" id="premium_check"/>
                            <div class="state p-success">
                                <!-- svg path -->
                                <svg class="svg svg-icon" viewBox="0 0 20 20">
                                    <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                </svg>
                                <label></label>
                            </div>
                        </div>
            
            
              <h3><span>Remove Premium</span></h3></div>
                   
                   
               </div>
               
           </div>
           <hr class="content-block"> <div class="clearfix"></div><div class="row user-content">
           <div class="col-lg-4">
                   <div class="form-group">
                       <h5>Change Password</h5>
                                <label for="exampleInputPassword1">New Password</label>
                                <input type="text" class="form-control form-right" value="" id="password" name="password" placeholder="Password" autocomplete="off" />
                                
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Confirm Password</label>
   
                                <input type="text" class="form-control form-right" value="" id="confirmPass" name="confirmPass" placeholder="Password" autocomplete="off" />
                                
                                
                            </div>
               </div></div>
        </div>
        
        <button  type="submit" class="btn float-right btn-green-bottom" id="premium-save-btn">SAVE</button>
        @if($page == 'all')
        <button  type="button" class="btn float-right btn-grey-bottom" onclick="window.location.href = '{{ url('admin/allUsersList') }}';">CANCEL</button>
        @else
        <button  type="button" class="btn float-right btn-grey-bottom" onclick="window.location.href = '{{ url('admin/premiumUsersList') }}';">CANCEL</button>
        @endif
        {!! Form::close() !!}
      
@endsection
@push('scripts') 
<script src="{{asset('admin/js/users.js')}}"></script>
@endpush