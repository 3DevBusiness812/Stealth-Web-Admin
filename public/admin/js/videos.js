$(document).ready(function () {
    
    $.fn.dataTable.ext.errMode = 'throw';
    
    var check_array = [];
    var check_array_string = '';
    $.cookie("chk_ar", null, { path: '/' });
    var page = $('.sec-search-top').attr('id');
   
    if(page == 'allvideos')
    {
        
            var category_search = $("#category_search").val();


            if($("#success_message").length == 1)
            {

                window.setTimeout(function () {
                    $("#success_message").hide();
                	allVideosListing(category_search);
                }, 1000);

            }
            else{

                allVideosListing(category_search);

            }

    		$('#allUsersId_filter input').attr("autocapitalize", "none");
    
    }
    
});


function clearDatatableState(tableId){
    
    var alltable = $('#'+tableId).DataTable({
        retrieve: true
    }).state.clear();    
    //alltable.draw();
}

var allVideosListing = function (category_search) {

    var video_count = $("#video_count").val();

    // alert(video_count);

    if(video_count > 0)
    {
        var sort_icon = true;
        var default_sort = [[ 1, "desc" ]];
    }
    else
    {
        var sort_icon = false;
        var default_sort = false;   
    }

    // alert(sort_icon);

    var video_path = $("#s3_video_folder").val();
    var url = params.site_url_path_guard + "/list_videos_dt";    
    var tblBrandsList = $('#allVideosList').DataTable({
        
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
                    d.searchData = category_search;
                }
        },        
        columns: [
            
            {data: 'videos', name: 'videos', orderable: false, searchable: false, render : function(data, type, row) {
	            if(row.videourl)
	            {

                    var video_shows = video_path+row.videourl;

	                return '<td><video class="video_border" style="width: 100%;" preload="metadata"><source src="'+video_shows+'" ></video></td>';
	            
                }
	            else{
	                return '<td></td>';
	            }
            }},
    
            {data: 'title', name: 'title', orderable: false, searchable: false, render : function(data, type, row) {
                if(row.title)
                {
                    return '<td>'+row.title+'</td>';
                }
                else{
                    return '<td></td>';
                }
            }},

            {data: 'category', name: 'category', orderable: sort_icon, searchable: false, render : function(data, type, row) {
                if(row.categorys)
                {
                    var category_display = '';
                    if((row.categorys).length > 25)
                    {
                        category_display = (row.categorys).substring(0, 25)+"...";
                    }
                    else
                    {
                        category_display = row.categorys;
                    }

                    category_display+='<a video_id="'+row.videoid+'" class="info-icon"><img src="'+params.site_url_path+'/images/info_icn.png" /></a>';
                    
                    return '<td>'+category_display+'</td>';
                }
                else{
                    return '<td></td>';
                }
            }},

            {data: 'actions', name: 'actions', orderable: false, searchable: false, render : function(data, type, row) {
                if(row.videoid){

                    var action_field = '';

                    var video_show = video_path+row.videourl;

                    action_field+='<a href="#" class="table-inner-link show_videos" video_title="'+row.title+'" videos="'+video_show+'"><span class="table-inner-span"><img src="'+params.site_url_path+'/images/icn_show_img.png" /></span></a>';
                    action_field+='<a href="'+params.site_url_path_guard +'/video_edit/'+row.videoid+'" class="table-inner-link"><span class="table-inner-span" ><img src="'+params.site_url_path+'/images/edit_img.png" /></span></a>';
                    action_field+='<a href="#" video_id="'+row.videoid+'" class="table-inner-link delete_video"><span class="table-inner-span"><img src="'+params.site_url_path+'/images/delete_icon.png" /></span></a>';

                    return '<td id="tdAction" align="right">'+action_field+'</td>';

                }
                else
                return '--';
            }},

        ],
        columnDefs: [
        {
            visible: false,
            searchable: false
        }, {targets: [ 3 ], className: 'dt-body-right'}],        
        // order: [[ 1, "desc" ]],
        order:default_sort,
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
            "emptyTable": "No Videos found"
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

$( "#allVideosList" ).on( "click", ".info-icon", function() {

    var url_categorys = params.site_url_path_guard + "/category_view";

    var video_id = $(this).attr('video_id');

    var data = {'video_id':video_id};

    $.ajax({
      url: url_categorys,
      data: data,
      cache: false,
      dataType: "json",
      type: "POST",
      success: function(result){
        if(result.status == 1)
        {

            var row_bit = 1;

            var html = "";

            $.map( result.category, function( val, i ) {

                if(row_bit == 1)
                {
                    // put row
                    html+= "<div class='row ml-0 mr-0'>";
                }

                var categories_display = '';
                if((val.categoryname).length > 15)
                {
                    categories_display = (val.categoryname).substring(0, 14)+"..";
                }
                else
                {
                    categories_display = val.categoryname;
                }

                html+="<div class='col-sm-6 col-md-4 pl-0 pr-0'>";
                    
                    html+="<div style='max-width:unset;' title='"+val.categoryname+"' class='tag-container fright-div clearfix'>";
                      
                        html+="<div class='pretty p-svg p-round'>";

                            html+="<input type='checkbox'>";

                            html+="<div class='state p-success'>";
                                                                       
                                html+="<svg class='svg svg-icon' viewBox='0 0 20 20'>";
                                    "<path d='M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z' style='stroke: white;fill:white;'></path>";
                                html+="</svg>";

                                html+="<label>"+categories_display+"</label>";

                            html+="</div>"

                        html+="</div>"

                    html+="</div>"

                html+="</div>";



                if(row_bit == 6)
                {
                    // close row
                    html+= "</div>";
                    row_bit = 0;

                }

                
                row_bit = row_bit+1;


            });

            if(row_bit < 1)
            {
                // close row
                html+= "</div>";
            }

            $("#category_contents").html(html);

            $("#AddCategoreis").modal('show');

        }
        // else
        // {

        // }
      }
    });

});

$( "#allVideosList" ).on( "click", ".show_videos", function() {

    var show_title = $(this).attr("video_title");

    var show_video = $(this).attr("videos");

    $("#video_title").html('');

    $("#play_videos").html('');

    var video_html = '<video style="width: 100%;" controls="controls" preload="metadata"><source src="'+show_video+'"></video>';

    $("#video_title").html(show_title);

    $("#play_videos").html(video_html);

    $("#videoModal").modal("show");

});

$( "#allVideosList" ).on( "click", ".delete_video", function() {


    // alert("yesss");

    var video_id = $(this).attr('video_id');

    $("#DeleteVideo").modal('show');


    $("#confirm_delete").attr("video_id", "");
    $("#confirm_delete").attr("video_id", video_id);


});

$("#confirm_delete").click(function(){
    var video_id = $(this).attr("video_id");

    var delete_uri = params.site_url_path_guard + "/delete_video";
    var data = {'video_id':video_id};


    $.ajax({
        url: delete_uri,
        type: 'post',
        data: data,
        dataType:"json",
        success: function(result) {
        if(result.status == 1)
        {
            $("#DeleteVideo").modal("hide");
            var response_box = '.completedResponse';
            var message = result.message;
            showResposeBox(response_box, 'alert-success', message);
            window.setTimeout(function () {
                var redirectUrl = params.site_url_path_guard+'/list_videos';
                $('.loader-overlay').addClass('display_none');
                // window.location.href = redirectUrl;
                 window.location.href = redirectUrl;
            }, 1000);
        }
        }
    });

});