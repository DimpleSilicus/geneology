$(document).ready(function () {

	var ploadVideoForm = $("#frmUploadVideo");
	
	ploadVideoForm.submit(function(e) {
		e.preventDefault();
		//var formData = ploadPictureForm.serialize();
		
		var fileName = $('#fileName').val();
		var file_data = $('#uVideo').prop('files')[0];
		
        var formData = new FormData(this);
		formData.append('file', file_data);
		formData.append('fileName', fileName);
		
		$("#UploadVideo #filename-div").removeClass("has-error");
    	$('#UploadVideo #form-errors-filename').html("");
    	
    	$("#UploadVideo #file-div").removeClass("has-error");
    	$('#UploadVideo #form-errors-file').html("");
		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/video-app/uploadVideo',
	        type: 'POST',
	        data: formData,
	        processData: false,
	        contentType: false,
	        success: function(data) {
	        	location.reload(); 
	        },
	        error: function(data) {
	        	console.log(data.responseText);
	            var obj = jQuery.parseJSON(data.responseText);	            
	            if (obj.fileName) {
	            	$("#UploadVideo #filename-div").addClass("has-error");
	            	$('#UploadVideo #form-errors-filename').html(obj.fileName);
	            }
	            if (obj.uVideo) {
	            	$("#UploadVideo #file-div").addClass("has-error");
	            	$('#UploadVideo #form-errors-file').html(obj.uVideo);
	            }
	        }
	    });
		
		return false;
	});
	
	
	
	var editVideoForm = $("#frmEditVideo");
	
	editVideoForm.submit(function(e) {
		e.preventDefault();
		var formData = editVideoForm.serialize();
				
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/video-app/editVideo',
	    	type: 'POST',
		    data: formData,
		    success: function(data) {
	        	location.reload(); 
	        },
	        error: function(data) {
	        	console.log(data.responseText);
	            var obj = jQuery.parseJSON(data.responseText);
	            
	            if (obj.fileName) {
	            	$("#EditVideo #filename-div").addClass("has-error");
	            	$('#EditVideo #form-errors-filename').html(obj.fileName);
	            }
	        }
	    });
		
		return false;
	});
	
	$(document).on("click", ".editPic", function() {	
		$('#EditVideo').modal('show');
		var videoId = $(this).attr("videoId");
		
		$("#EditVideo #filename-div").removeClass("has-error");
    	$('#EditVideo #form-errors-filename').html('');
				
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/video-app/details',
			type: 'POST',
			data: {videoId:videoId},
			success: function(data) {				
				$("#EditVideo #fileName").val(data[0].name);
				$("#EditVideo #videoId").val(data[0].id);				
			},
			error: function(data) {            	
				
			}
		});
	});
	
	$(document).on("click", ".deleteVideo", function() {
		var videoId = $(this).attr("videoId");	
				
		BootstrapDialog.confirm({
	        title: 'CONFIRM',
	        message: 'Are you sure you want to delete this video?',
	        type: BootstrapDialog.TYPE_DANGER, 
	        closable: true, 
	        draggable: true,
	        btnCancelLabel: 'Cancel', 
	        btnOKLabel: 'Ok', 
	        btnOKClass: '', 
	        callback: function (result) {
	            // result will be true if button was click, while it will be false if users close the dialog directly.
	            if (result) {
	            	$.ajax({
	        			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	        			url: '/video-app/deleteVideo',
	        			type: 'POST',
	        			data: {videoId: videoId},
	        			success: function(data) {
	        				location.reload(); 
	        			},
	        			error: function(data) {            	
	        				
	        			}
	        		});
	            } else {
	                return false;
	            }
	        }
	    });
	});
	
	$(document).on("click", ".shareVideo", function() {
		var videoId = $(this).attr("videoId");
		
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/video-app/shareVideo',
			type: 'POST',
			data: {videoId:videoId},
			success: function(data) {				
				location.reload(); 		
			},
			error: function(data) {            	
				
			}
		});
	});
	
	$(document).on("click", ".viewVideo", function() {		
		var path = $(this).attr("path");		
		$("#ZoomVideo #viewZoomVideo").attr("src",path);
		$("#ZoomVideo #vjs_video_3_html5_api").attr("src",path);	
		
	});
	
	$(document).on("click", ".shareVideoToUser", function() {
		var userId = $(this).attr("userId");
		var resourceId = $(this).attr("videoId");
		
		// ajax request start here
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/myapps/shareResource',
			type: 'POST',
			data: {resourceId:resourceId,shareTo:userId,resourceType:"video"},
			success: function(data) 
			{
			$('#hiddenjournalid').val('');
				location.reload();
			}
		});
	});
	
	
});