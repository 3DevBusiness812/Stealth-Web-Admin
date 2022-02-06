
/* 
 * Change Password
 */

$(document).ready(function () {
    $('#changePasswordModal').on('hide.bs.modal', changePasswordResetFunction );
});


/* Change Password form submit*/

$(document).on('submit', '#changePasswordForm', function (e) { 
    e.preventDefault();
    $('.textboxError').remove();

    var NewPassword = $('#newPassword').val();
    var ConfirmPassword = $('#confirmPassword').val();
    if ((NewPassword == "") || (ConfirmPassword == "")) {
            if (NewPassword == "") {
                $('<div class="textboxError">' + confirm_password_message_params.newPassword.required +  '</div>').insertAfter('#newPassword');
            } 
            if (ConfirmPassword == "") {
                $('<div class="textboxError">' + confirm_password_message_params.confirmPassword.required +  '</div>').insertAfter('#confirmPassword');
            }
            if(NewPassword != ConfirmPassword){
                $('<div class="textboxError">' + confirm_password_message_params.confirmPassword.same +  '</div>').insertAfter('#confirmPassword');
            }
        return false;
    }
    var url = params.site_url_path_guard +"/changePwd";
    var response_box = '.completedResponse';
    $(response_box).html('');
    var adminId = $('#adminId').val();
    var formData = new FormData(this);
    formData.append('adminId',adminId);
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData: false,
        success: function (response) {
            $('#changePasswordForm')[0].reset();
            var alertText =  response.message;
            $('.loader-overlay').removeClass('display_none');
            if (response.success) {
                $('#changePasswordModal').modal('hide');
                $('.loader-overlay').addClass('display_none');
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                showResposeBox(response_box, 'alert-success', alertText);                
            } else {
                $('.loader-overlay').addClass('display_none');
                showResposeBox(response_box, 'alert-danger', alertText);
            }
            if (response.redirect) {
                window.setTimeout(function () {
                    var redirectUrl = response.url;
                    $('.loader-overlay').addClass('display_none');
                    window.location.href = params.site_url_path_guard +redirectUrl;
                }, 1000);
            }
        },
        error: function (response) {
            showValidation(response);
            $('.loader-overlay').addClass('display_none');
        }
    });
     return false;
});


/**
 *  Change Password Modal Reset Function
 */

$(document).on('click', '#change_password_cancel', function (e) { 
    e.preventDefault();
    $('.textboxError').html('');
    $('#changePasswordForm')[0].reset();
});
    


function changePasswordResetFunction()
{
    $('.textboxError').html('');
    $('#changePasswordForm')[0].reset();
}

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