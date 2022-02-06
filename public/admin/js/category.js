/* 
 * Users listing.
 */

$(document).ready(function () {
    
    $.fn.dataTable.ext.errMode = 'throw';
    
    var check_array = [];
    var check_array_string = '';
    $.cookie("chk_ar", null, { path: '/' });
    var page = $('.sec-search-top').attr('id');
   
    if(page == 'allcategories')
    {
        

            if($("#success_message").length == 1)
            {

                window.setTimeout(function () {
                    $("#success_message").hide();
                	allCategoryListing();
                }, 1000);

            }
            else{

                allCategoryListing();

            }

    		$('#allUsersId_filter input').attr("autocapitalize", "none");
    
    }
    else if(page == 'addcategories')
	{

        $("#add_category").validate({
          rules: {
            categoryname: "required",
            normalizer: function(value) {
                return $.trim(value);
            }
          },
          messages: {
            categoryname: "Enter Category Name.",
          }
        });


        $("#add_category").submit(function(e){

            var category_name_field = $("#category_name").val();

            if($.trim(category_name_field) == '')
            {
                e.preventDefault();
                $("#category_name-error").html('Enter Category Name.');
                $("#category_name-error").show();
                return;
            }

        });



        if($("#error_message").length == 1)
        {

            $("#category_name-error").html('');
            $("#category_name-error").html($("#error_message").val());
            $("#category_name-error").show();

        }




	}

    
});


function clearDatatableState(tableId){
    
    var alltable = $('#'+tableId).DataTable({
        retrieve: true
    }).state.clear();    
    //alltable.draw();
}





//All users Listing
var allCategoryListing = function () {

    var category_count = $("#category_count").val();
    if(category_count > 0)
    {
        var sort_icon = 'true';
    }
    else
    {
        var sort_icon = 'false';
    }
    var url = params.site_url_path_guard + "/list_category_dt";     
    var tblBrandsList = $('#allCategoryList').DataTable({
        
        initComplete : function() {
            // $("#allUsersId_filter").detach().appendTo('#search-area');
        },    
        processing: false,
        serverSide: true,        
        pageLength: params.datatable_per_page_length,
        ajax: {
            url: url,
            type: 'GET',                    
            data: function (d) {
                    // d.searchData = $("#allUsersId_filter input").val()
                }
        },        
        columns: [
            
            {data: 'categoryname', name: 'categoryname', orderable: sort_icon, searchable: false, render : function(data, type, row) {
	            if(row.categoryname)
	            {
	                return '<td>'+row.categoryname+'</td>';
	            }
	            else{
	                return '<td></td>';
	            }
            }},

            {data: 'created', name: 'created', orderable: true, searchable: false, visible:false, render : function(data, type, row) {

                return '<td>'+row.created+'</td>';

            }},
    
            {data: 'categoryid', name: 'categoryid', orderable: false, searchable: false, render : function(data, type, row) {
	            if(row.categoryid){
	                // return '<td>'+row.categoryid+'</td>'
					return '<td style="text-align: right;" align="right" id="tdAction"><a href="'+params.site_url_path_guard +'/category_edit/'+row.categoryid+'" class="remove pull-right" title="Edit"><span class="pr15"><img src="'+params.site_url_path+'/images/edit_img.png"></span></a></td>'
	            }
	            else
	            return '--';
            }},

        ],
        order: [[ 1, "desc" ]],
        columnDefs: [
        {
            targets: [ 1 ],
            visible: false,
            searchable: false,
            orderable:true
        },{targets: [ 1 ], className: 'dt-body-right'}],
        bFilter: false,
        bInfo: false,
        bLengthChange: false,
        bRetrieve: true,
        pageLength: 25,
        language: {
            paginate: {
              next: '<i class="fa fa-chevron-right" aria-hidden="true">',
              previous: '<i class="fa fa-chevron-left" aria-hidden="true">'  
            }, 
            search: '', 
            // searchPlaceholder: "Search" ,
            "emptyTable": "No category found"
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





$("#category_name").keyup(function(e){

    $("#category_name-error").hide();

    var limitNum = 50;
    if ($(this).val().length > limitNum) {
        var field_value = $(this).val().substring(0, limitNum);
        $(this).val(field_value);
    }


});