/* 
 * Users listing.
 */

$(document).ready(function () {
    
    $.fn.dataTable.ext.errMode = 'throw';
    
    var check_array = [];
    var check_array_string = '';
    $.cookie("chk_ar", null, { path: '/' });
    var page = $('.sec-search-top').attr('id');



    if(page == 'challenge_edit_page')
    {

        $("#edit_cahllenge").validate({
          rules: {
            challenge_name: "required",
          },
          messages: {
            challenge_name: "Enter Challenge Name",
          }
        });

        var d = new Date();
        var n = d.getFullYear();

        var start_date = $("#start_date_hidden").val();

        var end_date = $("#end_date_hidden").val();
        
    }

   
    if(page == 'allusers')
    {
        

            if($("#success_message").length == 1)
            {

                window.setTimeout(function () {
                    $("#success_message").hide();
                    allUsersListing(true);
                }, 1000);

            }
            else{

                



                var state = $("#state").val();
                if(state == 1)
                {
                    $state = true;
                }
                else
                {
                    $state = false;
                }

                allUsersListing($state);

            }

    
    }
    else if(page == 'show_accounts_challenges')
    {

        var start_date = $("#start_date_hidden").val();

        var end_date = $("#end_date_hidden").val();

        if(start_date != '')
        {
            var date = new Date(start_date+' UTC');
            var start_year = date.getFullYear();
            var start_month = date.getMonth()+1;
            var start_day = date.getDate();
            var start_hours = date.getHours();
            var start_minutes = date.getMinutes();
            var start_seconds = date.getSeconds();
            if (start_month < 10) start_month = '0' + start_month;
            if (start_day < 10) start_day = '0' + start_day;
            if (start_hours < 10) start_hours = '0' + start_hours;
            if (start_minutes < 10) start_minutes = '0' + start_minutes;
            if (start_seconds < 10) start_seconds = '0' + start_seconds;
            var full_start_date = start_month+'/'+start_day+'/'+start_year+' '+start_hours+':'+start_minutes+':'+start_seconds;
            $("#start_date").val(full_start_date);
        }
        if(end_date != '')
        {
            var date = new Date(end_date+' UTC');
            var end_year = date.getFullYear();
            var end_month = date.getMonth()+1;
            var end_day = date.getDate();
            var end_hours = date.getHours();
            var end_minutes = date.getMinutes();
            var end_seconds = date.getSeconds();
             if (end_month < 10) end_month = '0' + end_month;
             if (end_day < 10) end_day = '0' + end_day;

            if (end_hours < 10) end_hours = '0' + end_hours;
            if (end_minutes < 10) end_minutes = '0' + end_minutes;
            if (end_seconds < 10) end_seconds = '0' + end_seconds;

            var full_end_date = end_month+'/'+end_day+'/'+end_year+' '+end_hours+':'+end_minutes+':'+end_seconds;
            
            if(full_end_date != 'NaN/NaN/NaN NaN:NaN:NaN')
            {
                $("#end_date").val(full_end_date);
            }
            else
            {
                $("#end_date").val('');
            }
        }

        show_accounts_challenges();

    }

    $('#allUsersId_filter input').attr("autocapitalize", "none");
    
});


function clearDatatableState(tableId){
    
    var alltable = $('#'+tableId).DataTable({
        retrieve: true
    }).state.clear();    
    //alltable.draw();
}

//All challenges Listing
var allUsersListing = function (state) {

    var url = params.site_url_path_guard + "/list_challenges_dt";     
    var tblBrandsList = $('#allUsersId').DataTable({
        
        initComplete : function() {
            $("#allUsersId_filter").detach().appendTo('#search-area');
        },    
        processing: false,
        serverSide: true,
        stateSave: state,      
        pageLength: params.datatable_per_page_length,
        ajax: {
            url: url,
            type: 'GET',                    
            data: function (d) {
                    d.searchData = $("#allUsersId_filter input").val()
                }
        },        
        columns: [
            
            {data: 'name', name: 'name', orderable: true, searchable: true, render : function(data, type, row) {
            if(row.name)
            {
                return '<td>'+row.name+'</td>';
            }
            else{
                return '<td></td>';
            }
            }},
    
            {data: 'code', name: 'code', orderable: true, searchable: true, render : function(data, type, row) {
            if(row.code){
                return '<td>'+row.code+'</td>'
            }
            else
            return '--';
            }},

            {data: 'challenge_user', name: 'challenge_user', orderable: true, searchable: true, render : function(data, type, row) {
                
            if(row.challenge_user)
            {
                return '<td>'+row.challenge_user+'</td>';
            }
            else
            {
                return '<td></td>';
            }
            

            }},

            {data: 'hiddencreated', name: 'hiddencreated', orderable: true, searchable: false, iDataSort: 3, render : function(data, type, row) {
            if(row.hiddencreated){
                return '<td>'+row.hiddencreated+'</td>'
            }
            else
            return '--';
            }},


            {data: 'start', name: 'start', orderable: true, searchable: true, render : function(data, type, row) {
                if(row.start){

                    var date = new Date(row.start+' UTC');
                    var start_year = date.getFullYear();
                    var start_month = date.getMonth()+1;
                    var start_day = date.getDate();
                    var start_hours = date.getHours();
                    var start_minutes = date.getMinutes();
                    var start_seconds = date.getSeconds();
                     if (start_month < 10) start_month = '0' + start_month;
                     if (start_day < 10) start_day = '0' + start_day;

                    if (start_hours < 10) start_hours = '0' + start_hours;
                    if (start_minutes < 10) start_minutes = '0' + start_minutes;
                    if (start_seconds < 10) start_seconds = '0' + start_seconds;



                    var full_start_date = start_month+'/'+start_day+'/'+start_year+' '+start_hours+':'+start_minutes+':'+start_seconds;

                    if(full_start_date != 'NaN/NaN/NaN NaN:NaN:NaN')
                    {
                        return '<td>'+full_start_date+'</td>';
                    }
                    else{
                        return '<td></td>';   
                    }
                }
                else{
                    return '<td></td>';
                }
            }},

            {data: 'end', name: 'end', orderable: true, searchable: true, render : function(data, type, row) {
                if(row.end){


                    var date = new Date(row.end+' UTC');
                    var end_year = date.getFullYear();
                    var end_month = date.getMonth()+1;
                    var end_day = date.getDate();
                    var end_hours = date.getHours();
                    var end_minutes = date.getMinutes();
                    var end_seconds = date.getSeconds();
                     if (end_month < 10) end_month = '0' + end_month;
                     if (end_day < 10) end_day = '0' + end_day;

                    if (end_hours < 10) end_hours = '0' + end_hours;
                    if (end_minutes < 10) end_minutes = '0' + end_minutes;
                    if (end_seconds < 10) end_seconds = '0' + end_seconds;

                    var full_end_date = end_month+'/'+end_day+'/'+end_year+' '+end_hours+':'+end_minutes+':'+end_seconds;

                    if(full_end_date != 'NaN/NaN/NaN NaN:NaN:NaN')
                    {
                        return '<td>'+full_end_date+'</td>';
                    }
                    else{
                        return '<td></td>';
                    }
                }
                else{
                    return '<td></td>';
                }
            
            }},

            {data: 'Action', name: 'Action', orderable: false, render : function(data, type, row) {
                return '<td align="right" id="tdAction"><a href="'+params.site_url_path_guard +'/challenges/'+row.id+'" class="edit" title="View"><span><img src="'+params.site_url_path+'/images/icn_show_img.png"></span></a><a href="'+params.site_url_path_guard +'/challenges_edit/'+row.id+'" class="remove" title="Edit"><span><img src="'+params.site_url_path+'/images/edit_img.png"></span></a></td>'
            }},



        ],
        columnDefs: [
        {
            targets: [ 3 ],
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

var show_accounts_challenges = function () {

    var url = params.site_url_path_guard + "/get_challenges_account_dt";     
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
                    d.searchData = $("#allUsersId_filter input").val(),
                    d.challenges_code = $("#challenges_code").val()
                }
        },        
        columns: [
            
            {data: 'firstname', name: 'firstname', orderable: true, searchable: true, render : function(data, type, row) {
                return '<td>'+row.firstname+'</td>'
            }},
    
            {data: 'lastname', name: 'lastname', orderable: true, searchable: true, render : function(data, type, row) {
                return '<td>'+row.lastname+'</td>'
            }},

            {data: 'email', name: 'email', orderable: true, searchable: true, render : function(data, type, row) {
                return '<td>'+row.email+'</td>'
            }},

            {data: 'country', name: 'country', orderable: true, searchable: true, render : function(data, type, row) {
                return '<td>'+row.country+'</td>'
            }},

            {data: 'gender', name: 'gender', orderable: true, searchable: true, render : function(data, type, row) {
            
            if((row.gender == 'f') || (row.gender == 'F'))
            {
                return '<td>Female</td>';
            }
            else if((row.gender == 'm') || (row.gender == 'M'))
            {

                return '<td>Male</td>';

            }
            else
            {

                return '<td>-</td>';

            }

            }},

            {data: 'age', name: 'age', orderable: true, searchable: true, render : function(data, type, row) {
                if((row.age > 0) && (row.age < 200))
                {
                    return '<td>'+row.age+'</td>';
                }
                else{
                    return '<td>-</td>';
                }
            }}

        ],
        columnDefs: [
        {
            // targets: [ 7 ],
            visible: false,
            searchable: false
        }],        
        // order: [[ 3, "desc" ]],
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

$(".delete_challenge").click(function(e){

    e.preventDefault();

    $("#confirmation_text").html('');
    $("#challenge_delete_confirmation").attr('delete_href','');
    $("#confirmation_text").html(user.policy_violation_challenge);
    var action = $(this).attr('href');
    $("#challenge_delete_confirmation").attr('delete_href',action);
    $("#delete_challenge_modal").modal("show");

});

$(".delete_challenge_and_user").click(function(e){

    e.preventDefault();

    $("#confirmation_text").html('');
    $("#challenge_delete_confirmation").attr('delete_href','');
    $("#confirmation_text").html(user.policy_violation_user_challenge);
    var action = $(this).attr('href');
    $("#challenge_delete_confirmation").attr('delete_href',action);
    $("#delete_challenge_modal").modal("show");

});

$("#challenge_delete_confirmation").click(function(e){

    e.preventDefault();

    var delete_fn = $(this).attr('delete_href');

    window.location.href = delete_fn;

});