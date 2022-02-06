@extends('layouts.app')
@section('content')


<div id="delete_user_modal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <button id="users_delete_confirmation" type="button" class="btn bg-green btn-sm text_white" delete_type="" delete_email="" delete_id="">Yes</button>
      </div>
    </div>
  </div>
</div>


<div class="create_users_top">

    <div class="form-row" style="margin-left: 0;">
        <a href="{{ route('admin.create_users') }}" class="btn-green mr-20">CREATE USER</a>
    </div>

</div>
<div class="sec-search-top" id="premiumusers">            
                <div class="form-row">
                    <div class="dropdown sample">
                    <button type="button" class="btn btn-select-menu btn-primary dropdown-toggle" data-toggle="dropdown">
                    Premium
                    </button>
                    <div class="dropdown-menu select-dropdown">
                        <a class="dropdown-item dropdown-item-normal" href="{{ url('admin/normalUsersList') }}">Normal</a>
                        <a class="dropdown-item dropdown-item-all" href="{{ url('admin/allUsersList') }}">All Users</a>
                    </div>
                    </div>
                    <div id="search-area" class="search-sec search-t">

                     </div>    
                    <!-- <div class="search-sec">
                        <input type="text" class="form-control search-t" placeholder="Search">
                    </div> -->
                    <a class="btn-green" id="btnSearchPremium">SEARCH</a>

                </div>            
        </div>
        <div class="clearfix"></div>
        <div class="completed_response_box shw_message_box completedResponse"></div>    
            <div class="page-wrapper ste-page-wrapper">
                <div class="table-responsive table-shadow">
                    <table class="table" id="premiumUsersId" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>USERS </th>
                                <th>EMAIL </th>
                                <th>CREATED DATE</th>
                                 <th>EXPIRATION DATE </th>  
                                 <th></th>
                                 <th></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                       
                    </table>
                </div>
                    <!-- <div class="pagination-wrapper">
            <nav aria-label="Page navigation example" class="pagin-holder clearfix">
                        <ul class="pagination float-right">


                            <li class="page-item"><a class="page-link page-link-cust" href="#" aria-label="Previous">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
        <span class="sr-only">Previous</span>
      </a></li>
                            <li class="page-item"><a class="page-link page-link-cust" href="#">1</a></li>
                            <li class="page-item"><a class="page-link page-link-cust" href="#">2</a></li>
                            <li class="page-item"><a class="page-link page-link-cust" href="#">3</a></li>
                            <li class="page-item"><a class="page-link page-link-cust" href="#">4</a></li>                            
                            <li class="page-item"><a class="page-link page-link-cust" href="#" aria-label="Next">
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        <span class="sr-only">Next</span>
      </a></li>
                        </ul>
                    </nav>

        </div>     -->
            </div>
        <button  type="button" class="btn login-btn float-right btn-green-b" id="set_normal" style="min-width: 200px !important;">REMOVE PREMIUM</button>
        </div>
    

        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
  <!--<footer class="sticky-footer">
            <p>&copy;2020 STEALTH. All rights reserved</p>
        </footer>-->
        <!-- Import Modal-->
       

        <!-- Logout Modal-->
       
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Comapny</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6">
                                <h3>Company Info</h3>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Company Logo</label>
                                    <div>
                                        <div class="logoDiv">
                                            <img src="{{ asset('images/companyLogoimg.jpg')}}"  width="148" height="98"/>
                                            <div><a href="#" class="addIcon" aria-hidden="true"></a></div>

                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Company Name</label>
                                    <input class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Company Description</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <h3>Server Info</h3>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Server Name</label>
                                    <input class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Database Name</label>
                                    <input class="form-control" id="exampleInputPassword1">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">User ID</label>
                                    <input class="form-control" id="exampleInputPassword1" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input class="form-control" id="exampleInputPassword1" >
                                </div>


                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="button" data-dismiss="modal">ADD</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade modal-popup" id="ChangePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control mrB_15" placeholder="Old Password">
                                <input type="text" class="form-control mrB_15" placeholder="New Password">
                                <input type="text" class="form-control mrB_15" placeholder="Confirm Password">

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="button" data-dismiss="modal">Save</button>

                    </div>
                </div>
            </div>
        </div>
@endsection
@push('scripts') 
<script src="{{asset('admin/js/users.js')}}"></script>

@endpush