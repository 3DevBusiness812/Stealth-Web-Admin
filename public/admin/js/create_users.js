    $(document).ready(function () {



var expiryDate_normal = $("#expiryDate_normal").val();

if(expiryDate_normal != '')
{

  $("#expiryDate_normal").datepicker("setDate",expiryDate_normal);
  
}


        $("#mobile_no").on("keypress keyup blur",function (event) {

           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $("#country_code").on("keypress keyup blur",function (e) {

            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

                if(e.which != 43)
                {
                    return false;
                }

            }


        });


        if($("#error_message").length == 1)
        {
            // $.toast({
            //     heading: 'Error',
            //     text: $("#error_message").val(),
            //     position: 'top-center',
            //     stack: false,
            //     // bgColor : '#1E6F16'
            //     icon: 'error',
            //     hideAfter : 18000,
            // });


            $("#email_custom_error").html('');
            $("#email_custom_error").html($("#error_message").val());
            $("#email_custom_error").show();

            $("#email").keyup(function(){

                $("#email_custom_error").hide();

            });

        }



    $("#users_create").submit(function(e){

        e.preventDefault();
        
        var mobile_no = $("#mobile_no").val();

        var country_code = $("#country_code").val();

        if((mobile_no != '') && (country_code == '')){
            
            $.toast({
                heading: 'Error',
                text: "You should fill country code",
                position: 'top-center',
                stack: false,
                icon: 'error'
            })

        }
        else{

            $(this).unbind(e);
            $("#users_create").submit();

        }

    });

$.validator.addMethod("custom_number", function(value, element) {
    return this.optional(element) || value === "NA" ||
        value.match(/^[0-9,\+-]+$/);
}, "Please enter a valid number, or 'NA'");

        // $("#users_create").validate();

        $("#users_create").validate({
          rules: {
            firstname: "required",
            mobile_no: { min:1, custom_number: true },
            country_code: { min:1 },
            email: {
              required: true,
              email: true
            }
          },
          messages: {
            firstname: "Enter First Name",
            mobile_no: "Please fill valid a phone number",
            country_code: "Please fill valid a country code",
            email: {
              required: "Enter User Email",
              email: "Enter a valid email address in the name@domain.com"
            }
          }
        });

    });






    $('#premium_check').change(function() {
        if(this.checked) {
           $('#userexpiryDiv').show();
           $("#no_expDiv").show();
           $('.premium_month').prop('checked', false); 
           var currentDate = new Date();
           var dd = currentDate.getDate();
           var mm = currentDate.getMonth()+1;
           var y = currentDate.getFullYear() + 1;
           var someFormattedDate = mm + '/'+ dd + '/'+ y;  
           $("#expiryDate_normal").datepicker("setDate",someFormattedDate);
        }else{
           $('#userexpiryDiv').hide();
        }
    });









    $('.premium_month').change(function() {
        var currentDate = new Date();
        var dd = currentDate.getDate();
        $('.premium_month').not(this).prop('checked', false); 
        if(this.checked) {
            if($(this).val() ==1){
                $("#no_expDiv").show();
                currentDate.setMonth(currentDate.getMonth() + +2);
                var mm = currentDate.getMonth();
                var y = currentDate.getFullYear();
               }
               else if($(this).val() ==3){
                $("#no_expDiv").show();
                currentDate.setMonth(currentDate.getMonth() + +4);
                var mm = currentDate.getMonth();
                var y = currentDate.getFullYear();
               }
               else if($(this).val() ==6){
                $("#no_expDiv").show();
                currentDate.setMonth(currentDate.getMonth() + +7);
                var mm = currentDate.getMonth();
                var y = currentDate.getFullYear();
               }
               else if($(this).val() ==50){
                var mm = currentDate.getMonth()+1;
                var y = currentDate.getFullYear()+50;
                $("#no_expDiv").hide();
               }
           
        }else{
            $("#no_expDiv").show();
            var mm = currentDate.getMonth()+1;
            var y = currentDate.getFullYear() + 1;
        }
        var someFormattedDate = mm + '/'+ dd + '/'+ y;  
           $("#expiryDate_normal").datepicker("setDate",someFormattedDate);
    });

$('.calendar-input').click(function(){
  setTimeout(function() {
    $('.datepicker').focus();
  }, 0);
});