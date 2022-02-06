@extends('layouts.app')
@section('content')
<div class="clearfix"></div>



<div id="delete_challenge_modal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog confirmation_modal" role="document">
    <div class="modal-content">
      <div class="modal-header bg-green">
        <img src="{{ asset('images/logo_inner.png')}}" alt="INFORCE911" width="40%;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text_white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="confirmation_text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm text_white bg-grey" data-dismiss="modal">No</button>
        <button id="challenge_delete_confirmation" type="button" class="btn bg-green btn-sm text_white" delete_href="">Yes</button>
      </div>
    </div>
  </div>
</div>







  
   <div class="container-fluid sec-search-top" id="challenge_edit_page">
	   	<div class="completed_response_box shw_message_box completedResponse"></div>     
	   	<div class="page-wrapper">
	       <div class="row challenge-content">
	           <input type="hidden" name="userId" value="{{isset($users->userid) ? $users->userid:''}}"/>
	           <input type="hidden" name="useremail" value="{{isset($users->useremail) ? $users->useremail:''}}"/>
	 
	           	<form style="width: 100%;" action="{{ route('admin.update_challenges', $get_challenge->id) }}" method="post" id="edit_cahllenge" class="users_create">

                  	 <!-- csrf_field() }} -->

                  	@csrf

                  	<input name="_method" type="hidden" value="PUT">

					<!--<div class="row m-side-0">

			      		<div class="col-lg-4 user-detail">

			      			<h4>Edit Challenge</h4>

			  			</div>

		  			</div> -->

		  			<div class="row m-side-0">

			       		<div class="col-lg-6">

							<div class="form-group">
			                    <label for="exampleInputPassword1">Challenge name</label>   
			                        <input type="text" class="form-control form-right" value="{{ $get_challenge->name }}" name="challenge_name" autofocus>                                
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
			                    <label for="exampleInputPassword1">Participants</label>   
			                    <input type="text" class="form-control form-right" value="{{ $get_challenge->challenges_attendance_count }}" name="participants" readonly>                                
			                </div>

			           	</div>

		           	</div>


		           	<div class="row m-side-0">
			      		
			      		<div class="col-lg-12">

							<div class="form-group">

								<button class="btn float-right btn-green-bottom challenge-btns" style="float: right;">Update</button>

	                        	<a class="btn float-right btn-grey-bottom challenge-btns" style="float: left;" href="{{ url('admin/list_challenges/1') }}">Cancel</a>

							</div>

						</div>

					</div>
	           
				 		<!-- Form::close() !!} -->

				 </form>
	           
	       </div>	  

	   	</div>

		<div class="page-wrapper mt20">
			<div class="row user-content">
	      		<div class="col-lg-12 user-detail">

	      			<h4>Action against policy violation</h4>

	  			</div>
	      		<div class="col-lg-12">

	      			<div class="row user-detail m0">
	      			
	      				@if(($get_challenge->account_delete_status == 0) && ($get_challenge->account_id != ''))

		      				@if($get_challenge->policy_violation <= 1)

		          				<a class="btn btn-md btn-warning delete_challenge" href="{{ route('admin.warning_policy_violation', [$get_challenge->account_id, $get_challenge->id] ) }}" style="color: #fff;">Delete Challenge & Warning for policy violation</a>

		      				@else

		          				<a class="btn btn-md btn-danger delete_challenge_and_user" href="{{ route('admin.delete_user_and_challenge', [$get_challenge->account_id, $get_challenge->id] ) }}" style="color: #fff;">Delete Challenge & Delete user account</a>

		      				@endif
	      				@else

								<a class="btn btn-md btn-warning delete_challenge" href="{{ route('admin.delete_challenge',[ $get_challenge->id] ) }}" style="color: #fff;">Delete Challenge</a>

	      				@endif

	  				</div>

				</div>
			</div>
		</div>

	</div>
      
@endsection
@push('scripts')

<script src="{{asset('admin/js/validation/jquery.validate.min.js')}}"></script>

<script src="{{asset('admin/js/challenges.js')}}"></script>

@endpush