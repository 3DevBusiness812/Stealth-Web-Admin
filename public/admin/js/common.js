/**
 * common.js
 * This js file handling the Common Functionalities throughout the website
 * Sep, 2019
 * ZCO Engineer
 */

$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	 localTimezone = moment.tz.guess();
});

/*	Work on the AJAX START */
$(document).ajaxStart(function () {
    
    var hasModelOpen = $( "body" ).hasClass( "modal-open" );
    if(hasModelOpen){
        $('.loader-overlay').addClass('zIndex_9999');
    }
        
        $('.loader-overlay').removeAttr('style');
	$('.loader-overlay').removeClass('display_none');
        
});

/*	Work on the AJAX Completion */
$(document).ajaxComplete(function () {   
   // alert('stop');
        
        $('.loader-overlay').removeAttr('style');
	$('.loader-overlay').addClass('display_none');
});

/*
* Mouse hover show description
*/
function funDescriptionMouseover(el) {
	var currentId = $(el).attr('id');
	var dataTitleVal = $('#' + currentId + ' .descripTitleReqVal').text();
	$(el).attr('title', dataTitleVal);
}

function funHidePopupAndReoload(popupId, reload, urlRedirect, loader) {
	if (!reload) reload = false;
	if (!urlRedirect) urlRedirect = false;
	if (!loader) loader = false;
	$('#' + popupId).modal('hide');
	if (loader) {
		$('.loader-overlay').removeClass('display_none');
	}
	if (reload) {
		location.reload();
	}
	if (urlRedirect) {
		redirectVal = $('#' + popupId).data('redirect-url');
		var redirectUrl = params.site_url_path + redirectVal;
		window.location.href = redirectUrl;
	}
}

bootstrap_alert = function () { };
bootstrap_alert.danger = function (message) {
	$('#alert_message').html('<div class="alert alert-danger" role="alert">' + message + '</div>');
};

bootstrap_alert.success = function (message) {
	$('#alert_message').html('<div class="alert alert-success" role="alert">' + message + '</div>');
};

function showValidation(response, alertClass) {
	if (!alertClass) alertClass = "";
	var errTextboxClass = 'textboxError';
	var errMsg = '';
	var j = 0;

	if (response.status == 401) {
		alertText = params.session_expired_and_redirect_login;
		$('.modal').modal('hide');
		$('.adminGeneralErrorMsgs').html(alertText);
		$('#sessionExpiredLogoutAdminModal').modal('show');
		window.setTimeout(function () {
			location.reload();
		}, 3000);

	} else if (response.status == 404 || response.status == 302) {
            
            // alert(response.status);
		alertText = 'We can\'t process the requested action, please try after sometimes.';
		$('.adminGeneralErrorMsgs').html(alertText);
		$('#sessionExpiredLogoutAdminModal').modal('show');
		window.setTimeout(function () {
			location.reload();
		}, 3000);
	} else if (response.status == 500) {
		alertText = params.error_occured_please_try_again;
		showResposeBox(alertClass, 'alert-danger', alertText);
	} else {
		var respArray = JSON.parse(response.responseText).errors;
		$('.' + errTextboxClass).remove();
		$.each(respArray, function (k, v) {
			j = parseInt(j) + 1;
			var $this = $('#' + k);

			if(k == 'img'){
                $('.fileDiv').after('<div class="' + errTextboxClass + '" style="color: #ff0000;">' + v + '</div>');
			}
			if(k =='point' || k =='levelPoint'){
				$('.pt_div').after('<div class="' + errTextboxClass + '" style="color: #ff0000;">' + v + '</div>');
			}
			else if(k == 'rewards' || k =='levelReward'){
				$('.rd_div').after('<div class="' + errTextboxClass + '" style="color: #ff0000;">' + v + '</div>');
			}
			else if(k == 'questionnairName' || k == 'trivianame'){
                $('.triviaAddqstn').after('<div class="' + errTextboxClass + '" style="color: #ff0000;">' + v + '</div>');
			}
			else{
                $('#' + k).after('<div class="' + errTextboxClass + '" style="color: #ff0000;">' + v + '</div>');
			}
			
			if (j == 1)
				$('#' + k).focus();
		});
	}
}

showResposeBox = function ($box_element, $response_type, $message) {
	$('.alert').remove();
	$($box_element).removeClass('display_none');
	var response_html = '<div class="alert ' + $response_type + ' alert-dismissible" role="alert"><button type="button" class="close sub-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + $message + '</div>';
	$($box_element).html(response_html);
	$($box_element).addClass('resp-tab-content');
	$($box_element).addClass('resp-tab-content-active');
};

$(".integerNoDecimal").keydown(function (event) {
	if (event.keyCode == 110 || event.keyCode == 190) {
		event.preventDefault();
	}
	if (event.shiftKey == true) {
		event.preventDefault();
	}
	if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {
	} else {
		event.preventDefault();
	}
	if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
		event.preventDefault();
});


$(".DecimalValuesOnly").keydown(function (e) {
	var key = e.which || e.keyCode;
	var number = $(this).val().split('.');
	if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
		// numbers
		key >= 48 && key <= 57 ||
		// Numeric keypad
		key >= 96 && key <= 105 ||
		// period/dot, comma, and minus, . on keypad
		//key == 190 || key == 188 || key == 109 || key == 110 ||
		key == 190 || key == 110 ||
		// Backspace and Tab and Enter
		key == 8 || key == 9 || key == 13 ||
		// Home and End
		key == 35 || key == 36 ||
		// left and right arrows
		key == 37 || key == 39 ||
		// Del and Ins
		key == 46 || key == 45) {

		// only one dot allowed
		if (number.length > 1 && (key == 190 || key == 110)) {
			return false;
		}

		if (key >= 48 && key <= 57 || key >= 96 && key <= 105) {
			if ($(this).attr('data-max_nondecimaldigits')) {
				var ndcount = $(this).data('max_nondecimaldigits');
			} else {
				var ndcount = 7;
			}
			if ($(this).attr('max')) {
				var max_value = $(this).attr('max');
			} else {
				var max_value = 99999999.99;
			}

			ndcount = ndcount - 1;

			// get the carat position
			// http://stackoverflow.com/questions/23221557
			var caratPos = getSelectionStart(this);
			//alert(caratPos);
			var dotPos = this.value.indexOf(".");
			//alert(dotPos);
			if ((caratPos > dotPos) &&
				(dotPos > -1) &&
				(number[1].length > 1)
			) {
				return false;
			} else if ((caratPos <= dotPos) &&
				(dotPos > -1) &&
				(number[0].length > ndcount)
			) {
				return false;
			} else if (dotPos <= -1 && number[0].length > ndcount) {
				return false;
			} else if (max_value < $(this).val()) {
				$(this).val(max_value)
				return false;
			}
		}
		return true;
	}

	return false;

});

$('body').on('shown.bs.collapse', '.collapse', function() {
    var target = $(this).attr('id');
    if($(this).data('parent') == '#outer-parent'){
      $('html, body').animate({
        scrollTop: $('#'+target).offset().top-100
        }, 1000);    
    }

})