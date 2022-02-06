// Delete video also shuld clear all filled data


// Should clear temp_category
// Reload checkboxes
// Empty title
// Empty file
var temp_category = [];
var video_data = [];

$("#add_more_videos").click(function(){

	var current_file_name = find_file_name();

	var source_file_name = find_source_file_name();

	var video_title = video_title_fn();

	var video_categorys = video_categorys_fn();

	if((current_file_name) && (current_file_name != ''))
	{
		var video_name = current_file_name;
	}
	else
	{
        $("#video_upload_validation").html('Select a Video file.');
        $("#video_upload_validation").show();
        // $("#error_empty_video").show();
		return;
	}

	if($.trim(video_title) == '')
	{
        $("#error_empty_title").show();
		return; 
	}

	if(video_categorys.length == 0)
	{
        $("#error_empty_category").show();
		return;
	}

	var temp_data_obj = {"video_title":video_title, "video_categorys":video_categorys,"video_name":video_name,"video_source_name":source_file_name};

	video_data.push(temp_data_obj);

	list_files(video_data);

	clear_inputs();

});

function find_file_name()
{

	var uploaded_file_name = $("#uploaded_file_name").val();

	return uploaded_file_name;

}

function find_source_file_name()
{

	var source_file_name = $("#source_file_name").val();

	return source_file_name;

}

function video_title_fn()
{
	var title = $("#title").val();

	return title; 
}

function video_categorys_fn()
{
	return temp_category;
}


function list_files(video_data)
{

	$("#new_file_selected").html('');

    var filename_html = '';

    var filename_i = 1;

    $.map(video_data, function( val, i ) {

        console.log("tf = "+JSON.stringify(val));

        filename_html+='<div class="col-md-12 col-lg-12"><div class="video-file-list">';
        filename_html+='<label class="video-btn-label">'+filename_i+'. '+val.video_source_name+'</label>';
        filename_html+='<a class="delete_temp_video" video_stored_path="'+val.video_name+'" position="'+i+'" href="#" class="video-delete-btn"><img src="'+params.site_url_path+'/images/delete_img.png"></a>';      
        filename_html+='</div></div>';
        
        filename_i = filename_i+1;

    });

    $("#file_list").html(filename_html);

}

function reload_category()
{

    var html = '';

    var categorys = JSON.parse($("#categorys").val());

    var row_bit = 1;

    var html = "";

    $.map( categorys, function( val, i ) {

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
            
            html+="<div style='max-width:unset' title='"+val.categoryname+"' class='tag-container fright-div clearfix'>";
              
                html+="<div class='pretty p-svg p-round'>";

                    html+="<input class='category_check' type='checkbox' value='"+val.categoryid+"'>";

                    html+="<div class='state p-success'>";
                                                               
                        html+="<svg class='svg svg-icon' viewBox='0 0 20 20'>";
                            "<path d='M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z' style='stroke: white;fill:white;'></path>";
                        html+="</svg>";

                        html+="<label>"+categories_display+"</label>";

                    html+="</div>";

                html+="</div>";

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

}


function clear_inputs()
{
	temp_category = [];

	reload_category();

	$("#title").val('');

	$("#uploaded_file_name").val('');

}


$( "#AddCategoreis" ).on( "change", ".category_check", function() {

    if($(this).prop('checked') == true){

        temp_category.push($(this).val());

    }
    else
    {
        var selectedIndex = $.inArray($(this).val(),temp_category);
        temp_category.splice(selectedIndex,1);
    }


});


$( "#file_list" ).on( "click", ".delete_temp_video", function() {

    var selectedIndex = $(this).attr('position');

    var video_name_to_delete = video_data[selectedIndex].video_name;

    video_data.splice(selectedIndex,1);

	var video_path = $(this).attr('video_stored_path');

	// video_delete_server(video_path);

    list_files(video_data);

    // Ajax for unset file fromm server //

});

$( "#new_file_selected" ).on( "click", ".delete_selected_video", function() {

	var video_path = $(this).attr('video_stored_path');

    $("#uploaded_file_name").val('');

	// video_delete_server(video_path);

	list_files(video_data);

});

$("#upload").click(function(){

	var current_file_name = find_file_name();

	var source_file_name = find_source_file_name()

	var video_title = video_title_fn();

	var video_categorys = video_categorys_fn();

	if(current_file_name != '')
	{
		if($.trim(video_title) == '')
		{

            $("#error_empty_title").show();
			return;
		}

		if(video_categorys.length == 0)
		{

            $("#error_empty_category").show();
			return;
		}

		var video_name = current_file_name;

		var temp_data_obj = {"video_title":video_title, "video_categorys":video_categorys,"video_name":video_name,"video_source_name":source_file_name};

		video_data.push(temp_data_obj);

	}

    if(video_data.length == 0)
    {
        $("#video_upload_validation").html('Select a Video file.');
        $("#video_upload_validation").show();
        return;
    }

	// Ajax to send data to server //


    var save_video_data = params.site_url_path_guard + "/save_video_data";

    $.ajax({
      url: save_video_data,
      data: {'video_data':JSON.stringify(video_data)},
      cache: false,
      dataType: "json",
      type: "POST",
      success: function(result){

      	if(result.status == 1)
  		{
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






$(document).ready(function() {  

    $("#file-3").on("change", handleVideoFileSelect);

});



function handleVideoFileSelect(e)
{

        $("#video_upload_validation").html('');
        $("#video_upload_validation").show();

        var ext = this.value.split('.').pop();

        if((ext != 'mp4') && (ext != 'avi') && (ext != 'avi') && (ext != 'mov') && (ext != 'wmv'))
        {
            $("#video_upload_validation").html('Invalid extension');
            $("#video_upload_validation").show();
            return;
        }



        e.preventDefault();
        
            $("#error_empty_video").hide();

            $("#uploaded_file_name").val('');

            $("#source_file_name").val('');



        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        selVidFiles = filesArr.length;

        var file_name = filesArr[0].name;

        var f = filesArr[0];

        var formData = new FormData();

        // formData.delete("fileInput");
        
        formData.append('fileInput', file_name);

        var get_s3_url = params.site_url_path_guard + "/get_s3_url";

        $.ajax({ 
            url:get_s3_url,
            method:"POST",
            enctype     : "multipart/form-data",  
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            dataType:"json",
            success:function(response)
            {
                var upload_url = response.Data.s3_upload_url;
                var s3file_name = response.Data.s3_file_name;

                var upload_flag = uploadToS3(upload_url, formData, e, f, s3file_name);

                // alert("upload_flag = "+upload_flag);

                if(upload_flag == 1)
                {
                    $("#source_file_name").val(file_name);
                    $("#uploaded_file_name").val(s3file_name);

                    var new_filename_i = (video_data.length)+1;
                    var new_filename_html = '';
                    new_filename_html+='<div class="col-md-12 col-lg-12"><div class="video-file-list">';
                    new_filename_html+='<label class="video-btn-label">'+new_filename_i+'. '+file_name+'</label>';
                    new_filename_html+='<a class="delete_selected_video" video_stored_path="'+s3file_name+'" href="#" class="video-delete-btn"><img src="'+params.site_url_path+'/images/delete_img.png"></a>';      
                    new_filename_html+='</div></div>';

                    $("#new_file_selected").html(new_filename_html);

                }

            },
            error: function (response) {
                alert("Error");
            },
        });


}



function uploadToS3(uplUrl, input, e, f, s3fname) {
    //var theFormFile = $('#theFile').get()[0].files[0];
    var theFormFile = f;
    var unq = Date.now();
    var uid = unq+f.name;
    var file = theFormFile;

    // uplUrl+= "&put-object-acl=public-read";
    // return;
    file['key'] = s3fname;
    file['acl'] = 'public-read';
    file['Content-Type'] = file.type;
    file['ContentDisposition'] = 'inline';

    var sucess_flag = 0;

    $.ajax({
        
        type: 'PUT',
        url: uplUrl,
        // Content type must much with the parameter you signed your URL with
       // contentType: 'image/jpeg',//'binary/octet-stream',
        contentType: file.type,//'binary/octet-stream',
        // this flag is important, if not set, it will try to send data as a form
        processData: false,
        // the actual file is sent raw
        async: false,
        data: file,
        success: function(response) {
            
            return sucess_flag = 1;

        }, 
        error:function() {
          
            return sucess_flag = 2;
        }


    });


    // alert("sf = "+sucess_flag);

    return sucess_flag;
}



$("#add_category").click(function(){

    $("#error_empty_category").hide();

    $("#AddCategoreis").modal('show');

});











function video_delete_server(video_path)
{

	var delete_video_data = params.site_url_path_guard + "/delete_video_data";

    $.ajax({
      url: delete_video_data,
      data: {'video_data':video_path},
      cache: false,
      dataType: "json",
      type: "POST",
      success: function(result){
      	if(result.status == 1)
  		{
  			list_files(video_data);
  		}
      }
    });


}





$(document).ready(function () {

	reload_category();

});


$("#title").keyup(function(){

    $("#error_empty_title").hide();

});