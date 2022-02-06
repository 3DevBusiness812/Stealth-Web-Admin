@extends('layouts.app')
@push('styles')
    <link href="{{asset('admin/css/toast/jquery.toast.css')}}" rel="stylesheet" type="text/css">
@endpush
@section('content')


@if (Session::has('message'))
   <!-- <input type="hidden" id="success_message" value="{{ Session::get('message') }}"> -->
    <div id="success_message" class="alert alert-success" role="alert" style="text-align: center;">
      {{ Session::get('message') }}
    </div>
@endif

            <div class="sec-search-top" id="allusers">            
                    
                    <div class="form-row">

                        <div id="search-area" class="search-sec search-t">

                         </div>

                        <a class="btn-green" id="btnSearchAll">SEARCH</a>

                    </div>            
            </div>
            <div class="clearfix"></div>
            <div class="completed_response_box shw_message_box completedResponse"></div>    
            <div class="page-wrapper ste-page-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover" id="allUsersId" style="width:100%">
                        <thead>
                            <tr>
                                 <th>CHALLENGE NAME </th>
                                 <th>CODE </th>
                                 <th>USERS</th>
                                 <!-- <th>CREATED DATE</th> -->
                                 <th>CREATED DATE</th>
                                 <th>START DATE</th>
                                 <th>END DATE</th>

                                 <th></th>
                                 <!-- <th></th> -->
                            </tr>
                        </thead>
                       
                    </table>
                </div>
         
            </div>

            <div>
                <input type="hidden" id="state" value="{{$state}}">
            </div>
    

@endsection
@push('scripts')
<script src="{{asset('admin/js/toast/jquery.toast.js')}}"></script>
<script src="{{asset('admin/js/challenges.js')}}"></script>
@endpush