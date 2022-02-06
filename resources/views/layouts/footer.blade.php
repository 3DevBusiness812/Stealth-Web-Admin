<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset('js/jquery-3.2.1.slim.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/sb-admin.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>  
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>  
<script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- Common js -->
<script src="{{asset('admin/js/common.js')}}"></script>
<!--cookie-->

<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables_bootstrap4.min.js')}}"></script>
<script src="~/Scripts/jquery-2.0.3.js" type="text/javascript"></script>

    <script>
    $('.dropdown-select').on( 'click', '.dropdown-menu li a', function() { 
	   var target = $(this).html();

	   //Adds active class to selected item
	   $(this).parents('.dropdown-menu').find('li').removeClass('active');
	   $(this).parent('li').addClass('active');

	   //Displays selected text on dropdown-toggle button
	   $(this).parents('.dropdown-select').find('.dropdown-toggle').html(target + ' <span class="caret"></span>');
	});
    </script>
    <!-- jQuery 3 -->
   
    
    <script type="text/javascript">
     $(".not-impmnt").click(function() {
        alert("Functionality not implemented.");
    });

    function notImplement() {
        alert("Functionality not implemented.");
    }
    var url = "{{ URL::to('/') }}";
    var storage_path = url.substring(0, url.lastIndexOf('/'));
	var localTimezone ='';

    var params = {    
        "site_url_path": "{{ URL::to('/') }}",
        "site_url_path_guard": "{{ URL::to('/').'/admin' }}",
    };
   
    var confirm_password_message_params = {
        'currentPassword': {
            'required': '{{ trans("admin.currentPassword_required") }} ',
        },
        'newPassword': {
            'required': '{{ trans("admin.newPassword_required") }} ',
        },
        'confirmPassword': {
            'required': '{{ trans("admin.confirmPassword_required") }} ',
            'same':'{!!trans("admin.password_same_confirmed") !!}',
            'length' : '{!!trans("admin.password_length") !!}',
        }
    }
    /** Message for login empty validation */
    var message_login = {
        'username': {
            'required': '{{ trans("admin.user_email_required") }} ',
            'email': '{{ trans("admin.user_email_email") }} ',
        },
        'password': {
            'required': '{{ trans("admin.user_password_required") }} ',
        },
        'credential': {
            'required': '{{ trans("admin.user_credential") }} ',
        },
    }  
    var user = {
        'choose_one': '{{ trans("admin.remove_premium") }}',
        'premiumConfirm': '{{ trans("admin.confirm_premium") }}',
        'normalConfirm': '{{ trans("admin.confirm_normal") }}',
        'delete_user_confirm': '{{ trans("admin.delete_user_confirm") }}',
        'policy_violation_challenge': '{{ trans("admin.policy_violation_challenge") }}',
        'policy_violation_user_challenge': '{{ trans("admin.policy_violation_user_challenge") }}',
    }
</script>
<script src="{{ asset('js/jquery.cookie.min.js') }}"></script>
<script src="{{asset('js/datepicker.min.js')}}"></script>
<script src="{{asset('admin/js/dashboard.js')}}"></script>
@stack('scripts')
