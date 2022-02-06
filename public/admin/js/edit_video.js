$("#save_video").click(function(){
	
  if($("#title").val() == '')
  {
    $("#title_error_msg").show();
    return;
  }

	var categories = $("#categories").serialize();

  if(categories == '')
  {
    $("#category_error_msg").show();
    return;
  }

	var title = $("#title").val();

	var video_id = $("#video_id").val();

	var data = {'categories':categories, 'title':title, 'video_id':video_id};

	var edit_video = params.site_url_path_guard + "/update_video";

    $.ajax({
      url: edit_video,
      data: data,
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



$("#show_categories").click(function(){

  $("#category_error_msg").hide();
  $("#AddCategoreis").modal('show');

});

$("#title").keyup(function(){

    $("#title_error_msg").hide();

});