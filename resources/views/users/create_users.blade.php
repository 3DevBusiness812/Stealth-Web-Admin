@extends('layouts.app')
@push('styles')
    <link href="{{asset('admin/css/toast/jquery.toast.css')}}" rel="stylesheet" type="text/css">
@endpush
@section('content')
<div class="clearfix"></div>

<div class="container-fluid mr-top sec-search-top" id="challenge_edit_page">

@if (Session::has('error_message'))
    <input type="hidden" id="error_message" value="{{ Session::get('error_message') }}">
@endif

<div class="completed_response_box shw_message_box completedResponse"></div>    
    
    <div class="page-wrapper">
 
        <div class="row user-content">

            <form style="width: 100%;" action="{{ route('admin.store_users') }}" method="post" id="users_create" class="users_create">

                @csrf

                <!-- <input name="_method" type="hidden" value="PUT"> -->

                <div class="col-lg-12 user-detail">

                    <h4>Create User Account</h4>

                </div>

                <div class="row m-side-0">

                    <div class="col-lg-6 user-detail">

                        <div class="form-group">
                            
                            <label for="exampleInputPassword1">Firstname</label>
                        
                            <input type="text" class="form-control form-right" value="{{ old('firstname') }}" name="firstname" autofocus>
                        
                        </div>

                    </div>

                    <div class="col-lg-6 user-detail">

                        <div class="form-group">
                            
                            <label for="exampleInputPassword1">Lastname</label>

                            <input type="text" class="form-control form-right" value="{{ old('lastname') }}" name="lastname">
                        
                        </div>

                    </div>

                </div>

                <div class="row m-side-0">

                    <div class="col-lg-6">

                        <div class="form-group">
                            
                            <label for="exampleInputPassword1">User Email</label>

                            <input type="email" id="email" class="form-control form-right" value="{{ old('email') }}" name="email">

                            <label style="display: none;" id="email_custom_error" class="error"></label>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="form-group">
                            
                            <label for="exampleInputPassword1">Phone</label>
                            <div class="row m-side-0">
                                <div class="col-sm-12 col-md-12 col-xl-12 p0">
                                    <div class="input-group">
                                        <input type="text" class="ph-fld-left form-control form-right valid" value="@if(old('country_code')){{ old('country_code') }}@else +1 @endif" name="country_code" id="country_code" style="border-bottom-right-radius: 0;border-top-right-radius: 0;text-align: center;width: 15%;margin-right: 0; border-right: 0;" aria-invalid="false" value="">
                                        <input pattern="[0-9]*" type="text" class="ph-fld-right form-control form-right valid" value="{{ old('mobile_no') }}" name="mobile_no" id="mobile_no" style="border-bottom-left-radius: 0;border-top-left-radius: 0;width: 75%;" aria-invalid="false">
                                    </div>
                                    <div>
                                        <label style="display: none;" id="mobile_no-error" class="error" for="mobile_no"></label>
                                    </div>
                                    <div>
                                        <label style="display: none;" id="country_code-error" class="error" for="country_code"></label>
                                    </div>
                                </div>                                
                            </div>
                        
                        </div>


                </div>

                </div>

                <div class="row m-side-0">

                    <!--<div class="col-lg-6">

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Age</label>
                                <select class="custom-select col-lg-4  form-right" id="inlineFormCustomSelect" style="height: 100%;" name="age">
                                    @if(old('age'))
                                        <option value="{{ old('age') }}" selected>{{ old('age') }}</option>
                                    @else
                                        <option value="" selected>Select age</option>
                                    @endif
                                    @for($i=1; $i<=150; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>

                    </div> -->

                    <div class="col-lg-6">

                        <div class="form-group">

                            <label for="exampleInputPassword1" class="d-flex mb-0">Gender</label>

                            @if(old('gender') == 'm')
                                <?php
                                    $m_selected = 'checked="checked"';
                                    $f_selected = '';
                                    $pns = '';
                                ?>
                            @elseif(old('gender') == 'f')
                                <?php
                                    $m_selected = '';
                                    $f_selected = 'checked="checked"';
                                    $pns = '';
                                ?>
                            @elseif(old('gender') == 'pns')
                                <?php
                                    $m_selected = '';
                                    $pns = 'checked="checked"';
                                    $f_selected = '';
                                ?>
                            @else
                                <?php
                                    $m_selected = 'checked="checked"';
                                    $f_selected = '';
                                    $pns = '';
                                ?>
                            @endif

                            <div class="control" style="margin-top: 16px;">
                              <input type="radio" id="customRadioInline1" name="gender" class="custom-control-input1" value="m" {{ $m_selected }}>
                              <label class="custom-control-label" for="customRadioInline1" style="padding-top: 7px; margin-right: 10px;">Male</label>
                              <input type="radio" id="customRadioInline2" name="gender" class="custom-control-input1" value="f" {{ $f_selected }}>
                              <label class="custom-control-label" for="customRadioInline2" style="padding-top: 7px; margin-right: 10px;">Female</label>
                              <input type="radio" id="customRadioInline3" name="gender" class="custom-control-input1" value="pns" {{ $pns }}>
                              <label class="custom-control-label" for="customRadioInline3" style="padding-top: 7px;">Prefer not to say</label>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6 user-detail" style="padding-top: 15px;">

                        <div class="" style="margin-top: 16px;">

                            @if(old('premium_account') == 1)
                                <?php
                                    $premium_account = "checked";
                                    $display_datepicker = "block";
                                ?>
                            @else
                                <?php
                                    $premium_account = "";
                                    $display_datepicker = "none";
                                ?>
                            @endif


                            <?php

                                $premium_one_month_checked = "";
                                $premium_three_month_checked = "";
                                $premium_six_month_checked = "";
                                $premium_fifty_years_checked = "";

                            ?>




                            @if(old('expiry_month') == 1)
                                <?php
                                    $premium_one_month_checked = "checked";
                                ?>
                            @elseif(old('expiry_month') == 3)
                                <?php
                                    $premium_three_month_checked = "checked";
                                ?>
                            @elseif(old('expiry_month') == 6)
                                <?php
                                    $premium_six_month_checked = "checked";
                                ?>
                            @elseif(old('expiry_month') == 50)
                                <?php
                                    $premium_fifty_years_checked = "checked";
                                ?>
                            @endif

                            <div style="float:left;" class="pretty p-svg p-curve checkbox">
                                <input type="checkbox" name="premium_account" value="@if(old('premium_account')) {{ old('premium_account') }} @else 1 @endif" id="premium_check" {{$premium_account}}/>
                                <div class="state p-success">
                                    <!-- svg path -->
                                    <svg class="svg svg-icon" viewBox="0 0 20 20">
                                        <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                    </svg>
                                    <label></label>
                                </div>
                            </div>

                            <h3 style="float: left;"><span>Premium account</span></h3>

                            <div class="user-detail col-12" id="userexpiryDiv" style="display:{{$display_datepicker}};">
                                <div class="row" id="no_expDiv">
                                    <p class="w-100">Expiration Date</p> 
                                   
                                    <div class="date-form">
                                        <span class="fa fa-calendar calendar-input"></span>
                                        <input type="text" class="form-control datepicker" id="expiryDate_normal" name="expiryDate_normal"  value="{{ old('expiryDate_normal') }}"  readonly>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="pretty p-svg p-curve checkbox">
                                        <input type="checkbox" class="premium_month" name ="expiry_month" value="1" {{$premium_one_month_checked}}/>
                                        <div class="state p-success">
                                            <!-- svg path -->
                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                            </svg>
                                            <label>1 Month</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-svg p-curve checkbox">
                                        <input type="checkbox" class="premium_month" name ="expiry_month" value="3" {{$premium_three_month_checked}}/>
                                        <div class="state p-success">
                                            <!-- svg path -->
                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                            </svg>
                                            <label>3 Months</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-svg p-curve checkbox">
                                        <input type="checkbox" class="premium_month" name ="expiry_month" value="6" {{$premium_six_month_checked}}/>
                                        <div class="state p-success">
                                            <!-- svg path -->
                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                            </svg>
                                            <label>6 Months</label>
                                        </div>
                                    </div>
                                    <div class="pretty p-svg p-curve checkbox">
                                        <input type="checkbox" class="premium_month" name="expiry_month" value="50" {{$premium_fifty_years_checked}}/>
                                        <div class="state p-success">
                                            <!-- svg path -->
                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                            </svg>
                                            <label>No Expiration</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!--<div class="row m-side-0">

                    <div class="col-lg-6"></div>

                </div> -->

                <div class="col-lg-12">

                    <div class="form-group">

                        <button class="btn float-right btn-green-bottom" style="margin-bottom: 20px;">SAVE</button>

                        <a class="btn float-right btn-grey-bottom" style="margin-bottom: 20px;" href="{{ route('admin.allUsersList') }}">CANCEL</a>

                    </div>

                </div>

            </form>













        </div>
       
    </div>

</div>
@endsection
@push('scripts')
<script src="{{asset('admin/js/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('admin/js/toast/jquery.toast.js')}}"></script>
<script src="{{asset('admin/js/create_users.js')}}"></script>

@endpush