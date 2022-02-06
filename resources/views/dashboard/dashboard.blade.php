@extends('layouts.app')
@section('content')
<div class="clearfix"></div>
   

        <div class="user-block-col"  onmouseover="" style="cursor: pointer;">
            <div class="col-lg-5 col-xl-4 user-block">

                <div class="" id="normal_div">
                    <div class="user-block-con"><img src="{{asset('images/icn_nuser.png')}}"></div>
                    <div>
                        <p>NORMAL USERS</p>
                        <h3>{{$normal_count}}</h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-xl-4 user-block2">
                <div class="" id="premium_div">
                    <div class="user-block-con"><img src="{{asset('images/icn_puser.png')}}"></div>
                    <div>
                        <p>PREMIUM USERS</p>
                        <h3>{{$premium_count}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">


            </div>
        </div>
       
@endsection
@push('scripts')
 <script src="{{ asset('admin/js/dashboard.js') }}"></script>
      
 @endpush    
   