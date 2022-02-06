<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/png">    
    <title>STEALTH</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/developer.css') }}" rel="stylesheet" type="text/css"> 
    <link href="{{ asset('css/style-stealth.css?10-07-2020') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css"/>
    <link href="{{asset('css/dataTables.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/select.dataTables.min.css')}}">
    <link href="{{asset('css/datepicker.css')}}" rel="stylesheet" type="text/css">

    @stack('styles')

 <style>
 .pretty{
     font-size:15px !important;
    }
 </style>   
</head>

<div id="logout_modal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog confirmation_modal" role="document">
    <div class="modal-content">
      <div class="modal-header bg-green">
        <img src="{{ asset('images/logo_inner.png')}}" alt="INFORCE911" width="40%;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text_white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm text_white bg-grey" data-dismiss="modal">No</button>
        <a class="btn bg-green btn-sm text_white" href="{{ url('admin/logout') }}">Yes</a>
      </div>
    </div>
  </div>
</div>

<body class="fixed-nav sticky-footer" id="page-top">
    <!-- Navigation-->
    <div class="loader-overlay display_none">  
        <div class="sk-fading-circle">
            <div class="sk-circle1 sk-circle"></div>
            <div class="sk-circle2 sk-circle"></div>
            <div class="sk-circle3 sk-circle"></div>
            <div class="sk-circle4 sk-circle"></div>
            <div class="sk-circle5 sk-circle"></div>
            <div class="sk-circle6 sk-circle"></div>
            <div class="sk-circle7 sk-circle"></div>
            <div class="sk-circle8 sk-circle"></div>
            <div class="sk-circle9 sk-circle"></div>
            <div class="sk-circle10 sk-circle"></div>
            <div class="sk-circle11 sk-circle"></div>
            <div class="sk-circle12 sk-circle"></div>

        </div>        
    </div>
    <nav class="navbar navbar-expand-lg fixed-top info-nav" id="mainNav">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><img src="{{ asset('images/logo_inner.png')}}" alt="INFORCE911" width="95%"></a>
        <!--<div class="sec-search ">
                        <div class="input-group mrg_search ">
                            <input type="text" class="form-control" placeholder="Search"> <span class="input-group-addon">
                                <button type="submit"><span class="fa fa-search"></span></button>
                            </span>
                        </div>
                        

                    </div>-->


        <!--<div class="navbar-title-wrap">
            <h1>Companies</h1>
        </div>-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> <span></span> <span></span> <span></span> </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><span><img src="{{ asset('images/icn_dashborad.png')}}"></span><span class="nav-link-text">Dashboard</span></a>

                    
                </li>
                <li class="nav-item {{ Route::is('admin.allUsersList') ? 'active' : '' }} {{ Route::is('admin.premiumUsersList') ? 'active' : '' }} {{ Route::is('admin.normalUsersList') ? 'active' : '' }}  {{ Route::is('admin.edit*') ? 'active' : '' }}  {{ Route::is('admin.create_users') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Users">
                    <a class="nav-link" href="{{ route('admin.allUsersList') }}"><span><img src="{{ asset('images/icn_user.png')}}"></span><span class="nav-link-text">Users</span></a>
                </li>
                
                <li class="nav-item {{ Route::is('admin.list_challenges') ? 'active' : '' }} {{ Route::is('admin.challenges_edit') ? 'active' : '' }} {{ Route::is('admin.challenges') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Challenges">
                    <a class="nav-link" href="{{ url('admin/list_challenges/0') }}"><span><img src="{{ asset('images/icn_challeges.png')}}"></span><span class="nav-link-text">Challenges</span></a>
                </li>

                <li class="nav-item {{ Route::is('admin.settings') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Settings">
                    <a class="nav-link" href="{{ route('admin.settings') }}"><span><img src="{{ asset('images/icn_settings.png')}}"></span><span class="nav-link-text">Settings</span></a>
                </li>





                <li><label class="sub-head">Stealth<span>GO</span></label></li>

                 <li class="nav-item {{ Route::is('admin.list_category') ? 'active' : '' }} {{ Route::is('admin.create_category') ? 'active' : '' }} {{ Route::is('admin.category_edit') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Category Management">
                    <a class="nav-link" href="{{ route('admin.list_category') }}"><span><img src="{{ asset('images/icn_category_mgt.png')}}"></span><span class="nav-link-text">Category Management</span></a>
                </li>

                 <li class="nav-item {{ Route::is('admin.list_videos') ? 'active' : '' }} {{ Route::is('admin.create_video') ? 'active' : '' }} {{ Route::is('admin.video_edit') ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Video Management">
                    <a class="nav-link" href="{{ route('admin.list_videos') }}"><span><img src="{{ asset('images/icn_video_mgt.png')}}"></span><span class="nav-link-text">Video Management</span></a>
                </li>

               
            </ul>
           

</div>
  
</nav>
<div class="content-wrapper">
        <div class="page-top">
            <h5 class="title-head">

                @if(Route::is('admin.challenges'))
                    <a href="{{ url('admin/list_challenges/1') }}" class="back_icon"><img src=" {{ asset('images/back_arrow.png')}}"></a>
                @elseif(Route::is('admin.challenges_edit'))
                    <a href="{{ url('admin/list_challenges/1') }}" class="back_icon"><img src=" {{ asset('images/back_arrow.png')}}"></a>
                @endif


                {{ Route::is('admin.dashboard') ? 'Dashboard' : '' }}
                {{ Route::is('admin.settings') ? 'Settings' : '' }} 
                {{ Route::is('admin.allUsersList') ? 'All Users' : '' }}
                {{ Route::is('admin.normalUsersList') ? 'Normal Users' : '' }}
                {{ Route::is('admin.premiumUsersList') ? 'Premium Users' : '' }}
                {{ Route::is('admin.editNormalUser') ? 'Edit User' : '' }}
                {{ Route::is('admin.editpostNormalUser') ? 'Edit User' : '' }}
                {{ Route::is('admin.editPremiumUser') ? 'Edit User' : '' }}
                {{ Route::is('admin.editpostPremiumUser') ? 'Edit User' : '' }}
                {{ Route::is('admin.editpostPremiumUser') ? 'Edit User' : '' }}
                {{ Route::is('admin.list_challenges') ? 'Challenges' : '' }}

                {{ Route::is('admin.list_category') ? 'Category Management' : '' }}

                {{ Route::is('admin.create_category') ? 'Add Category' : '' }}

                {{ Route::is('admin.category_edit') ? 'Edit Category' : '' }}

                {{ Route::is('admin.list_videos') ? 'Video Management' : '' }}

                {{ Route::is('admin.create_video') ? 'Add Video' : '' }}

                {{ Route::is('admin.challenges_edit') ? 'Edit Challenge' : '' }}

                {{ Route::is('admin.challenges') ? 'Challenge Details' : '' }}

            </h5>

            <span class="logout-icn"><a data-toggle="modal" data-target="#logout_modal" title="Logout"><img src="{{ asset('images/icn-logut.png')}}"></a> </span>

            <a class="nav-item nav-link fontregular dropdown-toggle pt-1 admin-btn ml-auto" id="bd-versions" data-toggle="dropdown" aria-haspopup="true"aria-expanded="true">
            Admin</a>
        </div>
      
  @yield('content')
</div>
@include('layouts.footer')
</body>
</html>
