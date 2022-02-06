/* 
 * Users listing.
 */

$(document).ready(function () {
    



    // if($("#success_message").length == 1)
    // {
    //     $.toast({
    //         heading: 'Success',
    //         text: $("#success_message").val(),
    //         position: 'top-center',
    //         stack: false,
    //         icon: 'success',
    //         bgColor : '#1E6F16'
    //     });
    // }


    $.fn.dataTable.ext.errMode = 'throw';
    
    $('.dropdown-item,.nav-item,#mainNav,.logout-icn').on('click',function(){
        clearDatatableState('allUsersId');
        clearDatatableState('premiumUsersId');
        clearDatatableState('normalUsersId');
        $('#normalUsersId_filter input').val('');
        $('#premiumUsersId_filter input').val('');
    });
    
    //var srch_string = $(".dataTables_filter input").val(); 
    //alert(srch_string);
    
    $('.datepicker').datepicker({
        autoclose: true,
        'startDate': new Date($('#tomorrow').val()),
        autoHide: true,
        zIndex: 2048,
    });
    
    $('.calendar-input').click(function(){
        setTimeout(function() {
            $('.datepicker').focus();
        }, 0);
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

    var check_array = [];
    var check_array_string = '';
    $.cookie("chk_ar", null, { path: '/' });
    var page = $('.sec-search-top').attr('id');
    if(page =='normalusers'){
        normalUsersListing();
        $('#normalUsersId_filter input').attr("autocapitalize", "none");
    }
    else if(page =='premiumusers'){
        premiumUsersListing();
        $('#premiumUsersId_filter input').attr("autocapitalize", "none");
    }
    else if(page =='allusers'){

            if($("#success_message").length == 1)
            {

                window.setTimeout(function () {
                    $("#success_message").hide();
                    allUsersListing();
                    $('#allUsersId_filter input').attr("autocapitalize", "none");
                }, 1000);

            }
            else{

                allUsersListing();
                $('#allUsersId_filter input').attr("autocapitalize", "none");

            }




    }

    // handle checkboxes
    $(document).on("click", '.notif_checkbox', function(event) { 
    if($(this).prop("checked") == true){
        $(this).each(function () {            
            check_array.push($(this).attr('data-at'));
        });
    }
    else if($(this).prop("checked") == false){               
        check_array.splice($.inArray($(this).attr('data-at'), check_array),1);
    }   
    // stringify array object
    check_array_string = JSON.stringify(check_array);
    
    // set cookie
    $.cookie('chk_ar', check_array_string, {path:'/'});
    
    });

    
});


function clearDatatableState(tableId){
    
    var alltable = $('#'+tableId).DataTable({
        retrieve: true
    }).state.clear();    
    //alltable.draw();
}

var premiumUsersListing = function () {
    //$('.loader-overlay').removeClass('display_none');
    var url = params.site_url_path_guard + "/premiumUsersListDt";     
    var tblBrandsList = $('#premiumUsersId').DataTable({
        initComplete : function() {
            $("#premiumUsersId_filter").detach().appendTo('#search-area');
        },
        processing: false,
        serverSide: true,
        pageLength: params.datatable_per_page_length,
        ajax: {
            url: url,
            type: 'GET',
            data: function (d) {
                d.searchData = $("#premiumUsersId_filter input").val()
            }
        },
        columns: [
            {data: 'Select', name: 'Select', orderable: false, searchable: false, render : function(data, type, row) {  
                    
                var cookieParsed =  $.parseJSON($.cookie('chk_ar'));
                if($.cookie('chk_ar') && $.inArray(row.useremail, cookieParsed) !== -1){
                    var check_status = 'checked';
                }
                else{
                    var check_status = '';
                }
            return '<td scope="row">'+
                        '<div class="pretty p-svg p-curve">'+
                            '<input type="checkbox" name="notif_checkbox[]" class="notif_checkbox" data-at="'+row.useremail+'" '+check_status+'>'+
                            '<div class="state p-success">'+
                            '<svg class="svg svg-icon" viewBox="0 0 20 20">'+
                                                '<path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>'+
                                            '</svg>'+
                                        '<label></label>'+
                                    '</div>'+
                                '</div></td>'
        }},
        {data: 'name', name: 'name', orderable: true, searchable: true, render : function(data, type, row) {                
            return '<td scope="row"><a href="'+params.site_url_path_guard +'/editPremiumUser/'+row.userid+'/premium">'+row.name+'</a></td>'
        }},
        {data: 'useremail', name: 'useremail', orderable: true, searchable: true, render : function(data, type, row) {
            return '<td>'+row.useremail+'</td>'}},
        {data: 'created', name: 'created', orderable: true, searchable: true,  iDataSort: 5,render : function(data, type, row) {
            if(row.created)
            return '<td>'+row.created+'</td>'
            else
            return '--';
        }},
        {data: 'expiry', name: 'expiry', orderable: true, searchable: true, iDataSort: 6, render : function(data, type, row) {
            if(row.expiry && row.is_non_expiring ==0)
            return '<td>'+row.expiry+'</td>'
            else if(row.is_non_expiring !=0)
            return '<td>No Expiry</td>'
            else
            return '--';
         }}, 
         {data: 'hiddencreated', name: 'hiddencreated', orderable: true, searchable: false, iDataSort: 3, render : function(data, type, row) {
            if(row.hiddencreated){
                return '<td>'+row.hiddencreated+'</td>'
            }
            else
            return '--';
        }},
        {data: 'hiddenexpiry', name: 'hiddenexpiry', orderable: true, searchable: false, iDataSort: 4, render : function(data, type, row) {
            if(row.hiddenexpiry){
                return '<td>'+row.hiddenexpiry+'</td>'
            }
            else
            return '--';
        }},
        {data: 'Action', name: 'Action', orderable: false, render : function(data, type, row) {
            return '<td align="right"><a href="'+params.site_url_path_guard +'/editPremiumUser/'+row.userid+'/premium" class="edit" title="Edit"><span><img src="'+params.site_url_path+'/images/edit_img.png"></span></a><a href="#" class="remove" id="deleteUser'+row.userid+'" onclick="deletePremiumUser(\''+row.userid+'\',\''+row.useremail+'\');" title="Delete"><span><img src="'+params.site_url_path+'/images/delete_icon.png"></span></a></td>'}}

        ],  
        columnDefs: [
        {
            targets: [ 5,6 ],
            visible: false,
            searchable: false
        }],
        order: [[ 4, "desc" ]],
        bFilter: true,
        bInfo: false,
        bLengthChange: false,
        bRetrieve: true,
        pageLength: 25,
        // stateSave: true,
        language: {
            paginate: {
              next: '<i class="fa fa-chevron-right" aria-hidden="true">',
              previous: '<i class="fa fa-chevron-left" aria-hidden="true">'  
            }, 
            search: '', 
            searchPlaceholder: "Search" ,
            "emptyTable": "No users found"
          },
        errMode: "none",        
    });   
    
    $('#premiumUsersId_filter input').unbind();
    
    $('#btnSearchPremium').click(function (){
        var srch_string = $("#premiumUsersId_filter input").val();        
        tblBrandsList.search(srch_string).draw();
    });
    
    $('#premiumUsersId_filter input').on( 'keypress', function (e) {
        if (e.which == 13){            
            var srch_string = $("#premiumUsersId_filter input").val();   
            tblBrandsList.search(srch_string).draw();
        }
    });
     
}

var normalUsersListing = function () {    
 
    var url = params.site_url_path_guard + "/normalUsersListDt";     
    var tblBrandsList = $('#normalUsersId').DataTable({
        initComplete : function() {
            $("#normalUsersId_filter").detach().appendTo('#search-area');
        },
        processing: false,
        serverSide: true,
        pageLength: params.datatable_per_page_length,
        ajax: {
            url: url,
            type: 'GET',
            data: function (d) {
                d.searchData = $("#normalUsersId_filter input").val()
            }
        },
        columns: [
            {data: 'Select', name: 'Select', orderable: false, searchable: false, render : function(data, type, row) {  
                
                var cookieParsed =  $.parseJSON($.cookie('chk_ar'));
                if($.cookie('chk_ar') && $.inArray(row.useremail, cookieParsed) !== -1){
                    var check_status = 'checked';
                }
                else{
                    var check_status = '';
                }
            return '<td scope="row">'+
                        '<div class="pretty p-svg p-curve">'+
                            '<input type="checkbox" name="notif_checkbox[]" class="notif_checkbox" data-at="'+row.useremail+'" '+check_status+'>'+
                            '<div class="state p-success">'+
                            '<svg class="svg svg-icon" viewBox="0 0 20 20">'+
                                                '<path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>'+
                                            '</svg>'+
                                        '<label></label>'+
                                    '</div>'+
                                '</div></td>'
        }},
        {data: 'name', name: 'name', orderable: true, searchable: true, render : function(data, type, row) {
               
            return '<td scope="row"><a href="'+params.site_url_path_guard +'/editNormalUser/'+row.userid+'/normal">'+row.name+'</a></td>'
        }},
        {data: 'useremail', name: 'useremail', orderable: true, searchable: true, render : function(data, type, row) {
            return '<td>'+row.useremail+'</td>'}},
        {data: 'created', name: 'created', orderable: true, searchable: true, iDataSort: 4, render : function(data, type, row) {
            if(row.created)
            return '<td>'+row.created+'</td>'
            else
            return '--';
        }},
        {data: 'hiddencreated', name: 'hiddencreated', orderable: true, searchable: false, iDataSort: 3, render : function(data, type, row) {
            if(row.hiddencreated){
                return '<td>'+row.hiddencreated+'</td>'
            }
            else
            return '--';
        }},
        {data: 'Action', name: 'Action', orderable: false, render : function(data, type, row) {
            return '<td align="right"><a href="'+params.site_url_path_guard +'/editNormalUser/'+row.userid+'/normal" class="edit" title="Edit"><span><img src="'+params.site_url_path+'/images/edit_img.png"></span></a> <a href="#" class="remove" id="deleteUser'+row.userid+'" onclick="deleteNormalUser(\''+row.userid+'\');" title="Delete"><span><img src="'+params.site_url_path+'/images/delete_icon.png"></span></a></td>'}}    
        ],  
        columnDefs: [
        {
            targets: [ 4 ],
            visible: false,
            searchable: false
        }],
        order: [[ 3, "desc" ]],
        bFilter: true,
        bInfo: false,
        bLengthChange: false,
        bRetrieve: true,
        pageLength: 25,
        // stateSave: true,
        language: {
            paginate: {
              next: '<i class="fa fa-chevron-right" aria-hidden="true">',
              previous: '<i class="fa fa-chevron-left" aria-hidden="true">'  
            }, 
            search: '', 
            searchPlaceholder: "Search" ,
            "emptyTable": "No users found"
          },
        errMode: "none", 
    });
    
    $('#normalUsersId_filter input').unbind();
        
    $('#btnSearchNormal').click(function (){
        var srch_string = $("#normalUsersId_filter input").val();        
        tblBrandsList.search(srch_string).draw();
    });
    
    $('#normalUsersId_filter input').on( 'keypress', function (e) {
        if (e.which == 13){            
            var srch_string = $("#normalUsersId_filter input").val();   
            tblBrandsList.search(srch_string).draw();
        }
    });
         
}



//All users Listing
var allUsersListing = function () {

    var url = params.site_url_path_guard + "/allUsersListDt";     
    var tblBrandsList = $('#allUsersId').DataTable({
        
        initComplete : function() {
            $("#allUsersId_filter").detach().appendTo('#search-area');
        },    
        processing: false,
        serverSide: true,        
        pageLength: params.datatable_per_page_length,
        ajax: {
            url: url,
            type: 'GET',                    
            data: function (d) {
                    d.searchData = $("#allUsersId_filter input").val()
                }
        },        
        columns: [
            {data: 'Select', name: 'Select', orderable: false, searchable: false, render : function(data, type, row) {  
                
              
            return '<td scope="row"> </td>'
        }},
        {data: 'name', name: 'name', orderable: true, searchable: true},
        {data: 'useremail', name: 'useremail', orderable: true, searchable: true, render : function(data, type, row) {
            return '<td>'+row.useremail+'</td>'}},
    
        {data: 'created', name: 'created', orderable: true, searchable: false, iDataSort: 5, render : function(data, type, row) {
            if(row.created){
                return '<td>'+row.created+'</td>'
            }
            else
            return '--';
        }},        
        {data: 'expiry', name: 'expiry', orderable: true, searchable: true, render : function(data, type, row) {
            if(row.expiry && row.is_non_expiring ==0)
            return '<td>'+row.expiry+'</td>'
            else if(row.is_non_expiring !=0)
            return '<td>No Expiry</td>'
            else
            return '--';
        }},
        {data: 'hiddencreated', name: 'hiddencreated', orderable: true, searchable: false, iDataSort: 3, render : function(data, type, row) {
            if(row.hiddencreated){
                return '<td>'+row.hiddencreated+'</td>'
            }
            else
            return '--';
        }},
        
        {data: 'Action', name: 'Action', orderable: false, render : function(data, type, row) {
            if(row.user_status ==0)
            return '<td align="right" id="tdAction"><a href="'+params.site_url_path_guard +'/editNormalUser/'+row.userid+'/all" class="edit" title="Edit"><span><img src="'+params.site_url_path+'/images/edit_img.png"></span></a> <a href="#" class="remove" id="deleteUser'+row.userid+'" onclick="deleteNormalUser(\''+row.userid+'\');" title="Delete"><span><img src="'+params.site_url_path+'/images/delete_icon.png"></span></a></td>'
            if(row.user_status ==1)
            return '<td align="right"><a href="'+params.site_url_path_guard +'/editPremiumUser/'+row.userid+'/all" class="edit" title="Edit"><span><img src="'+params.site_url_path+'/images/edit_img.png"></span></a><a href="#" class="remove" id="deleteUser'+row.userid+'" onclick="deletePremiumUser(\''+row.userid+'\',\''+row.useremail+'\');" title="Delete"><span><img src="'+params.site_url_path+'/images/delete_icon.png"></span></a></td>'
        }}    

        ],
        columnDefs: [
        {
            targets: [ 5 ],
            visible: false,
            searchable: false
        }],        
        order: [[ 3, "desc" ]],
        bFilter: true,
        bInfo: false,
        bLengthChange: false,
        bRetrieve: true,
        pageLength: 25,
        // stateSave: true,
        language: {
            paginate: {
              next: '<i class="fa fa-chevron-right" aria-hidden="true">',
              previous: '<i class="fa fa-chevron-left" aria-hidden="true">'  
            }, 
            search: '', 
            searchPlaceholder: "Search" ,
            "emptyTable": "No users found"
          },

        errMode: "none",
             
    });   
    $('#allUsersId_filter input').unbind();
        
    $('#btnSearchAll').click(function (){
        var srch_string = $("#allUsersId_filter input").val();        
        tblBrandsList.search(srch_string).draw();
    });
     
     $('#allUsersId_filter input').on( 'keypress', function (e) {
        if (e.which == 13){            
            var srch_string = $("#allUsersId_filter input").val();   
            tblBrandsList.search(srch_string).draw();
        }
    });
}

// Set user as Premium/Normal
$('#set_premium').click(function(){
  var response_box = '.completedResponse';
  var arrSelected1 =  $.parseJSON($.cookie('chk_ar'));
  if(arrSelected1 == null){
      alert(user.choose_one);
      return false;
  }
  if (confirm(user.premiumConfirm)) {
  var url = params.site_url_path_guard +"/setPremiumUsers";
  var arrSelected = JSON.stringify(arrSelected1);
    $.ajax({
            type: "Post",
            url: url,
            cache: false,
            data: { 'arrSelected': arrSelected },
            traditional: true,
            dataType: 'json',
            beforeSend:function(){
                $('#set_premium').prop('disabled', true);
            },
            success: function (response) {
            var alertText =  response.message;
            $(response_box).html('');
                if (response.success) {
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
  }
});

$('#set_normal').click(function(){
    var response_box = '.completedResponse';
    var arrSelected1 =  $.parseJSON($.cookie('chk_ar'));
    var url = params.site_url_path_guard +"/setNormalUsers";
    var arrSelected = JSON.stringify(arrSelected1);
    if(arrSelected1 == null){
        alert(user.choose_one);
        return false;
    }
    if(confirm(user.normalConfirm)){
    $.ajax({
            type: "Post",
            url: url,
            cache: false,
            data: { 'arrSelected': arrSelected },
            traditional: true,
            dataType: 'json',
            beforeSend:function(){
                $('#set_normal').prop('disabled', true);
            },
            success: function (response) {
            var alertText =  response.message;
            $(response_box).html('');
                if (response.success) {
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
     }
  });

  $('#userType').on('change',function(){  
    var table = $('#allUsersId').DataTable({
        retrieve: true
    });
    table.draw();
});

//Edit form submit for normal users
$('#editformNormaluser').on('submit', function(){
    var url = params.site_url_path_guard +"/editpostNormalUser";
    var response_box = '.completedResponse';
    var password = $('#password').val();
    var confirmPass = $('#confirmPass').val();
    $('.textboxError').html('');
    if (password !='' && password.length < 8) {
        var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.length+'</div>';
        $(textErr).insertAfter('#password');
        return false;
    }
    if(password !='' && confirmPass ==''){
        var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.required+'</div>';
        $(textErr).insertAfter('#confirmPass');
        return false;
    }
    if (confirmPass !='' && (password != confirmPass)) {
        var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.same+'</div>';
        $(textErr).insertAfter('#confirmPass');
        return false;
    }
    var fd = new FormData(this);
    if($("#premium_check").prop('checked') == true){
        fd.append("setpremium", 1);
    }
        $.ajax({
            url:url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend:function(){
                $('#normal-save-btn').prop('disabled', true);
            },
            success: function (response) {
                var alertText = response.message;
                $('.shw_message_box').show();
                $('.loader-overlay').removeClass('display_none');
                if (response.success) {
                    $('.loader-overlay').addClass('display_none');
                    $('html, body').animate({
                        scrollTop: 0
                    }, 800);
                    showResposeBox(response_box, 'alert-success', alertText); 
                } else {
                    $('.loader-overlay').addClass('display_none');
                    showResposeBox(response_box, 'alert-danger', alertText);
                    $('.shw_message_box').delay(5000).fadeOut();
                }
                if (response.redirect) {
                    
                    window.setTimeout(function () {
                        var redirectUrl = params.site_url_path_guard + response.url;
                        $('.loader-overlay').addClass('display_none');
                        window.location.href = redirectUrl;                        
                        // window.history.go(-1);
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
    
    /*  Delete Normal User Function */

    function deleteNormalUser_confirm(action)
    {
        var page = $('.sec-search-top').attr('id');
        var id = $(action).attr('delete_id');
        // if (result) 
        // {
            var response_box = '.completedResponse';
            $(response_box).html('');
            $.ajax({ 
                    url:params.site_url_path_guard +'/deleteNormalUser',
                    method:"get",
                    dataType:"json",
                    data:{ userId : id},
                    beforeSend:function(){
                            },
                    success:function(response){ 
                        $("#delete_user_modal").modal("hide");
                        $('.shw_message_box').show();
                        var alertText = response.message;
                        if(response.success == false){
                            showResposeBox(response_box, 'alert-danger', alertText);
                            $('.shw_message_box').delay(4000).fadeOut();   
                        }else{
                            $("#deleteUser"+id).closest('tr').remove();
                            showResposeBox(response_box, 'alert-success', alertText); 
                            $('.shw_message_box').delay(4000).fadeOut();   
                            if(page =='allusers'){
                                var allUsersId = $('#allUsersId').DataTable();
                                if($('#allUsersId tbody tr:visible').length > 0) {                            
                                    window.setTimeout(function () {
                                        allUsersId.ajax.reload( null, false ); 
                                    }, 1000 );
                                }else{                            
                                    window.setTimeout(function () {
                                        allUsersId.ajax.reload( null, true ); 
                                    }, 1000 );
                                }
                            }else{
                                var normalUsersId = $('#normalUsersId').DataTable();
                                if($('#normalUsersId tbody tr:visible').length > 0) {                            
                                    window.setTimeout(function () {
                                        normalUsersId.ajax.reload( null, false ); 
                                    }, 1000 );
                                }else{                            
                                    window.setTimeout(function () {
                                        normalUsersId.ajax.reload( null, true ); 
                                    }, 1000 );
                                }
                            }
                            
                            
                        }
                    },
                    error: function (response) {
                        $("#delete_user_modal").modal("hide");
                        showValidation(response);
                        $('.loader-overlay').addClass('display_none');
                    }
            }); 
        // }
    }

    function deleteNormalUser(id)
    {  

        $("#users_delete_confirmation").attr('delete_type','');
        $("#confirmation_text").html('');
        $("#users_delete_confirmation").attr('delete_id','');
        $("#users_delete_confirmation").attr('delete_email','');
        $("#confirmation_text").html(user.delete_user_confirm);
        $("#users_delete_confirmation").attr('delete_id',id);
        // $("#users_delete_confirmation").attr('delete_email',email);
        $("#users_delete_confirmation").attr('delete_type','deleteNormalUser_confirm');
        $("#delete_user_modal").modal("show");
        return;
    }
    
    /*  Delete Normal User Function */

    function deletePremiumUser_confirm(action)
    {

            var page = $('.sec-search-top').attr('id');
            var id = $(action).attr('delete_id');
            var email = $(action).attr('delete_email');

            var response_box = '.completedResponse';
            $(response_box).html('');
            $.ajax({ 
                    url:params.site_url_path_guard +'/deletePremiumUser',
                    method:"get",
                    dataType:"json",
                    data:{ emailId : email},
                    beforeSend:function(){
                            },
                    success:function(response){ 

                        $("#delete_user_modal").modal("hide");

                        $('.shw_message_box').show();
                        var alertText = response.message;
                        if(response.success == false){
                            showResposeBox(response_box, 'alert-danger', alertText);
                            $('.shw_message_box').delay(4000).fadeOut();   
                        }else{
                            $("#deleteUser"+id).closest('tr').remove();
                            showResposeBox(response_box, 'alert-success', alertText); 
                            $('.shw_message_box').delay(4000).fadeOut();   
                            if(page =='allusers'){
                                var allUsersId = $('#allUsersId').DataTable();
                                if($('#allUsersId tbody tr:visible').length > 0) {                            
                                    window.setTimeout(function () {
                                        allUsersId.ajax.reload( null, false ); 
                                    }, 1000 );
                                }else{                            
                                    window.setTimeout(function () {
                                        allUsersId.ajax.reload( null, true ); 
                                    }, 1000 );
                                }
                            }else{
                                var premiumUsersId = $('#premiumUsersId').DataTable();
                                if($('#premiumUsersId tbody tr:visible').length > 0) {                            
                                    window.setTimeout(function () {
                                        premiumUsersId.ajax.reload( null, false ); // user paging is not reset on reload
                                    }, 1000 );
                                }else{                            
                                    window.setTimeout(function () {
                                        premiumUsersId.ajax.reload( null, true ); // user paging is not reset on reload
                                    }, 1000 );
                                }
                            }
                            
                            
                        }
                    },
                    error: function (response) {
                        $("#delete_user_modal").modal("hide");
                        showValidation(response);
                        $('.loader-overlay').addClass('display_none');
                    }
            }); 

    }

    function deletePremiumUser(id,email)
    { 
        $("#users_delete_confirmation").attr('delete_type','');
        $("#confirmation_text").html('');
        $("#users_delete_confirmation").attr('delete_id','');
        $("#users_delete_confirmation").attr('delete_email','');
        $("#confirmation_text").html(user.delete_user_confirm);
        $("#users_delete_confirmation").attr('delete_id',id);
        $("#users_delete_confirmation").attr('delete_email',email);
        $("#users_delete_confirmation").attr('delete_type','deletePremiumUser_confirm');
        $("#delete_user_modal").modal("show");
        return;
    }


//Edit form submit for Premium users
$('#editformPremiumuser').on('submit', function(){
    var url = params.site_url_path_guard +"/editpostPremiumUser";
    var response_box = '.completedResponse';
    var password = $('#password').val();
    var confirmPass = $('#confirmPass').val();
    $('.textboxError').html('');
    if (password !='' && password.length < 8) {
        var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.length+'</div>';
        $(textErr).insertAfter('#password');
        return false;
    }
    if(password !='' && confirmPass ==''){
        var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.required+'</div>';
        $(textErr).insertAfter('#confirmPass');
        return false;
    }
    if (confirmPass !='' && (password != confirmPass)) {
        var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.same+'</div>';
        $(textErr).insertAfter('#confirmPass');
        return false;
    }
    var fd = new FormData(this);
    if($("#premium_check").prop('checked') == true){
        fd.append("setpremium", 1);
    }
        $.ajax({
            url:url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend:function(){
                $('#premium-save-btn').prop('disabled', true);
            },
            success: function (response) {
                var alertText = response.message;
                $('.shw_message_box').show();
                $('.loader-overlay').removeClass('display_none');
                if (response.success) {
                    $('.loader-overlay').addClass('display_none');
                    $('html, body').animate({
                        scrollTop: 0
                    }, 800);
                    showResposeBox(response_box, 'alert-success', alertText);                
                } else {
                    $('.loader-overlay').addClass('display_none');
                    showResposeBox(response_box, 'alert-danger', alertText);
                    $('.shw_message_box').delay(5000).fadeOut();
                }
                if (response.redirect) {
                    window.setTimeout(function () {
                        var redirectUrl = params.site_url_path_guard + response.url;
                        $('.loader-overlay').addClass('display_none');
                        // window.location.href = redirectUrl;
                        window.history.go(-1);
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
    
    
    //Edit form submit for normal users
$('#settings').on('submit', function(){
    var url = params.site_url_path_guard +"/changeSettings";
    var response_box = '.completedResponse';
    var currentPass = $('#currentPass').val();   
    var password = $('#password').val();    
    var confirmPass = $('#confirmPass').val();
    $('.textboxError').html('');
    
    if( (currentPass =='') ||  (password =='') || (password !='' && confirmPass =='') || (confirmPass !='' && (password != confirmPass)) ) {  
        if(currentPass =='') {
            var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.currentPassword.required+'</div>';
            $(textErr).insertAfter('#currentPass');
        }

        if(password =='') {
            var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.newPassword.required+'</div>';
            $(textErr).insertAfter('#password');
        }

        if(confirmPass ==''){
            var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.required+'</div>';
            $(textErr).insertAfter('#confirmPass');
            
        }
        if (confirmPass !='' && (password != confirmPass)) {
            var textErr = '<div class="textboxError" style="color: #ff0000;">'+confirm_password_message_params.confirmPassword.same+'</div>';
            $(textErr).insertAfter('#confirmPass');
            
        }
        return false;
    }
    var fd = new FormData(this);
        $.ajax({
            url:url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend:function(){
            },
            success: function (response) {
                var alertText = response.message;
                $('.shw_message_box').show();
                $('.loader-overlay').removeClass('display_none');
                if (response.success) {
                    $('.loader-overlay').addClass('display_none');
                    $('html, body').animate({
                        scrollTop: 0
                    }, 800);
                    showResposeBox(response_box, 'alert-success', alertText);                
                } else {
                    $('.loader-overlay').addClass('display_none');
                    showResposeBox(response_box, 'alert-danger', alertText);
                    $('.shw_message_box').delay(5000).fadeOut();
                }
                if (response.redirect) {
                    window.setTimeout(function () {
                        var redirectUrl = params.site_url_path_guard + response.url;
                        $('.loader-overlay').addClass('display_none');
                        window.location.href = redirectUrl;
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









    $("#users_delete_confirmation").click(function(){

        var delete_function = $(this).attr('delete_type');

        if(delete_function == 'deletePremiumUser_confirm')
        {
            deletePremiumUser_confirm($(this));
        }
        if(delete_function == 'deleteNormalUser_confirm')
        {
            deleteNormalUser_confirm($(this));
        }

    });