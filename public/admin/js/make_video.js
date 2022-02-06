var imageFileArray = [];
$(document).ready(function() {	

	$("#file-3").on("change", handleVideoFileSelect);

});




/* Video file upload*/
function handleVideoFileSelect(e)
{

		e.preventDefault();
		
		var files = e.target.files;
		var filesArr = Array.prototype.slice.call(files);
		selVidFiles = filesArr.length;

		var file_name = filesArr[0].name;

		var f = filesArr[0];

		var formData = new FormData();

		formData.delete("fileInput");
		
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
				// alert(JSON.stringify(response));

				// console.log(response);

				var upload_url = response.Data.s3_upload_url;
				// alert("upload_url="+upload_url);
				var s3file_name = response.Data.s3_file_name;
				// alert("s3file_name="+s3file_name);
				var upload_flag = uploadToS3(upload_url, formData, e, f, s3file_name);
				// basic_s3_upload(upload_url);
				// alert(upload_flag);
				
			},
			error: function (response) {
				alert("Error");
				// $('#submitAddNewProduct').attr('disabled',false);
			
				// return 2;
			},
		});


}




function basic_s3_upload(upload_url)
{
 var file = $('#file-3')[0].files[0];
        // var file = field[0].files[0];
        var url = '<%= raw @presigned_url %>';
        console.log(file);
        $.ajax({
            type : 'PUT',
            url : upload_url,
            data : file,
            processData: false,  // tell jQuery not to convert to form data
            contentType: file.type,
            success: function(json) { console.log('Upload complete!') },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('Upload error: ' + XMLHttpRequest.responseText);
            }
        });
}





 function uploadToS3(uplUrl, input, e, f, s3fname) {
	//    var theFormFile = $('#theFile').get()[0].files[0];
    var theFormFile = f;
	var unq = Date.now();
	var uid = unq+f.name;
	
	var file = theFormFile;



	alert("file = "+theFormFile);
	alert("unq = "+unq);
	alert("uid = "+uid);
	
	// return;


	file['key'] = s3fname;
	file['acl'] = 'public-read';
	file['Content-Type'] = file.type;
 	
    $.ajax({
        
        type: 'PUT',
        url: uplUrl,
		xhr: function () {
           
            var xhr = new window.XMLHttpRequest();
			if(e.target.id == 'imageInput')
			{
				progressClass = "img_progress";
			}else if(e.target.id == 'videoInput')
			{
				progressClass = "vid_progress";
			}else if(e.target.id == 'documentInput')
			{
				progressClass = "doc_progress";
			}
			
            xhr.upload.addEventListener('progress', function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
					 $('#submitAddNewProduct').attr('disabled',true);
					if(e.target.id == 'imageInput')
					{   
						$('#Imgprogress_bar').append('<div id="'+uid+'" class="img_progress image-loader"><img src="'+params.site_url_path+'/images/s3loading.gif" alt="processing..."/><div>');
						$('.img_progress').show();
						/*$('.img_progress').css({
							width: percentComplete * 100 + '%'
						});*/
						if (percentComplete === 1) {
							//$('.img_progress').addClass('hide');
						}
					
					}else if(e.target.id == 'videoInput')
					{
						$('#Vidprogress_bar').append('<div id="'+uid+'" class="vid_progress image-loader"><img src="'+params.site_url_path+'/images/s3loading.gif" alt="processing..."/><div>');
						$('.vid_progress').show();
						$('.vid_progress').css({
							width: percentComplete * 100 + '%'
						});
						if (percentComplete === 1) {
							$('.vid_progress').addClass('hide');
						}
					}else if(e.target.id == 'documentInput')
					{
						$('#Docprogress_bar').append('<div id="'+uid+'" class="doc_progress image-loader"><img src="'+params.site_url_path+'/images/s3loading.gif" alt="processing..."/><div>');
						$('.doc_progress').show();
						$('.doc_progress').css({
							width: percentComplete * 100 + '%'
						});
						if (percentComplete === 1) {
							$('.doc_progress').addClass('hide');
						}
					}
                    
					
                }
            }, false);
            xhr.addEventListener('progress', function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    console.log(percentComplete);
                    $(progressClass).css({
                        width: percentComplete * 100 + '%'
                    });
                }
            }, false);
            return xhr;
        },
        // Content type must much with the parameter you signed your URL with
       // contentType: 'image/jpeg',//'binary/octet-stream',
		contentType: file.type,//'binary/octet-stream',
        // this flag is important, if not set, it will try to send data as a form
        processData: false,
        // the actual file is sent raw
        data: file,
        success: function(response) {
            
			return 1; //Success
        }, 
        error:function() {
          
		  return 2; //Error;
        }

    })

    return;
  }
