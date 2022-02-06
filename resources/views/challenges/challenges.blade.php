@extends('layouts.app')
@section('content')
<div class="clearfix"></div>
  
   <div class="container-fluid mr-top">
	   	<div class="completed_response_box shw_message_box completedResponse"></div>     
	   	<div class="page-wrapper">
	       <div class="row challenge-content">
	           <input type="hidden" name="userId" value="{{isset($users->userid) ? $users->userid:''}}"/>
	           <input type="hidden" name="useremail" value="{{isset($users->useremail) ? $users->useremail:''}}"/>
	           
                <div style="width: 100%;">

                    <!--<div class="row m-side-0">
                        <div class="col-lg-6">
                            <h4 class="challenge_details">Challenge Details</h4>
                        </div>
                    </div> -->
                    <div class="row m-side-0">
            			<div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Challenge name</label>
                                <input type="text" class="form-control form-right" value="{{ $get_challenge->name }}" name="challenge_name" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Challenge code</label>
                                <input type="text" class="form-control form-right" value="{{ $get_challenge->code }}" name="challenge_code" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row m-side-0">
                        <div class="col-lg-6">   
                    		<div class="form-group">
                                <label for="exampleInputPassword1">Challenge owner</label>   
                                    <input type="text" class="form-control form-right" value="{{ $get_challenge->challenge_user }}" name="challenge_owner" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                    		<div class="form-group">
                                <label for="exampleInputPassword1">Created date</label>   
                                <input type="text" class="form-control form-right" value="{{ date('m/d/Y', strtotime($get_challenge->created)) }}" name="challenge_created" readonly>
                            </div>
                        </div>
                    </div>


                    <div class="row m-side-0">
                        <div class="col-lg-6">
                    		<div class="form-group">
                                <label for="exampleInputPassword1">Start date</label>   
                                <input type="text" class="form-control form-right" id="start_date" name="start_date" readonly>
                                <input type="hidden" class="form-control form-right" value="{{ $get_challenge->start }}" id="start_date_hidden" name="start_date" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                    		<div class="form-group">
                                <label for="exampleInputPassword1">End date</label>   
                                <input type="text" class="form-control form-right"  id="end_date" name="end_date" readonly>
                                <input type="hidden" class="form-control form-right" value="{{ $get_challenge->end }}" id="end_date_hidden">         
                            </div>
                        </div>
                    </div>


                    <div class="row m-side-0">

                        <div class="col-lg-6 m-side-0">
                    		<div class="form-group">
                                <label for="exampleInputPassword1">Participants</label>   
                                <input type="text" class="form-control form-right" value="{{ $get_challenge->challenges_attendance_count }}" name="participants" readonly>                              
                            </div>
                        </div>

                    </div>

                </div>


            </div>










	           
	       </div>

	   	</div>

		<div class="participants"><h4>Participants</h4></div>

        <div class="sec-search-top" id="show_accounts_challenges">
                
            <div class="form-row">

                <div id="search-area" class="search-sec search-t">

                 </div>

                <!-- <div class="search-sec">
                    <input type="text" class="form-control search-t" placeholder="Search">
                </div> -->

                <a class="btn-green" id="btnSearchAll">SEARCH</a>

            </div>

        </div>
        <div class="clearfix"></div>

        <input type="hidden" id="challenges_code" value="{{ $get_challenge->code }}">
        
        <div class="completed_response_box shw_message_box completedResponse"></div>    
            
        <div class="page-wrapper ste-page-wrapper">

            <div class="table-responsive">
                <table class="table table-hover" id="allUsersId" style="width:100%">
                    <thead>
                        <tr>
                             <!-- <th></th> -->
                             <th>FIRSTNAME</th>
                             <th>LASTNAME</th>
                             <th>EMAIL</th>
                             <th>COUNTRY</th>
                             <th>GENDER</th>
                             <th>AGE</th>
                            <!-- <th class="list_action">&nbsp;</th> -->
                        </tr>
                    </thead>
                   
                </table>
            </div>
     	</div>

	</div>
      
@endsection
@push('scripts') 
<script src="{{asset('admin/js/challenges.js')}}"></script>
@endpush