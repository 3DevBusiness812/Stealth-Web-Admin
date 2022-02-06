
$(document).ready(function () {    
    $('.loader-overlay').hide();
});
$('#normal_div').on('click',function(){  

    window.location.href = params.site_url_path_guard +"/normalUsersList";
});
$('#premium_div').on('click',function(){  
  window.location.href = params.site_url_path_guard +"/premiumUsersList";
});

$('.loginBtn').click(function()      
{ 
    $('.textboxError').remove();    
        if(!$('#useremail').val() && !$('#password').val())   { 
            $('<div class="textboxError pl-3">' + message_login.credential.required + '</div>').insertAfter('#password');
            return false;
        }   
        if( !$('#useremail').val() ) { 
            $('<div class="textboxError pl-3">' + message_login.username.required + '</div>').insertAfter('#useremail');
            return false;
        }
         if( !$('#password').val() ) { 
            $('<div class="textboxError pl-3">' + message_login.password.required + '</div>').insertAfter('#password');
            return false;

        }
   
  
});