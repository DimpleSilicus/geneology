$(document).ready(function () {

	var ploadPictureForm = $("#frmUploadPicture");
	
	ploadPictureForm.submit(function(e) {
		e.preventDefault();
		//var formData = ploadPictureForm.serialize();
		
		var fileName = $('#fileName').val();
		var file_data = $('#uPicture').prop('files')[0];
		
        var formData = new FormData(this);
		formData.append('file', file_data);
		formData.append('fileName', fileName);
		
		$("#UploadPik #filename-div").removeClass("has-error");
    	$('#UploadPik #form-errors-filename').html("");
    	
    	$("#UploadPik #file-div").removeClass("has-error");
    	$('#UploadPik #form-errors-file').html("");
		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/picture-app/uploadPicture',
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
	            	$("#UploadPik #filename-div").addClass("has-error");
	            	$('#UploadPik #form-errors-filename').html(obj.fileName);
	            }
	            if (obj.uPicture) {
	            	$("#UploadPik #file-div").addClass("has-error");
	            	$('#UploadPik #form-errors-file').html(obj.uPicture);
	            }
	        }
	    });
		
		return false;
	});
	
	
	
	var editPictureForm = $("#frmEditPicture");
	
	editPictureForm.submit(function(e) {
		e.preventDefault();
		var formData = editPictureForm.serialize();
				
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/picture-app/editPicture',
	    	type: 'POST',
		    data: formData,
		    success: function(data) {
	        	location.reload(); 
	        },
	        error: function(data) {
	        	console.log(data.responseText);
	            var obj = jQuery.parseJSON(data.responseText);
	            
	            if (obj.fileName) {
	            	$("#EditPic #filename-div").addClass("has-error");
	            	$('#EditPic #form-errors-filename').html(obj.fileName);
	            }
	        }
	    });
		
		return false;
	});
	
	$(document).on("click", ".editPic", function() {	
		$('#EditPic').modal('show');
		var picId = $(this).attr("picId");
				
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/picture-app/details',
			type: 'POST',
			data: {picId:picId},
			success: function(data) {				
				$("#EditPic #fileName").val(data[0].name);
				$("#EditPic #picId").val(data[0].id);				
			},
			error: function(data) {            	
				
			}
		});
	});
	
	$(document).on("click", ".deletePic", function() {
		var picId = $(this).attr("picId");	
				
		BootstrapDialog.confirm({
	        title: 'CONFIRM',
	        message: 'Are you sure you want to delete this picture?',
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
	        			url: '/picture-app/deletePic',
	        			type: 'POST',
	        			data: {picId: picId},
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
	
	$(document).on("click", ".sharePic", function() {
		var picId = $(this).attr("picId");
		
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/picture-app/sharePic',
			type: 'POST',
			data: {picId:picId},
			success: function(data) {				
				location.reload(); 		
			},
			error: function(data) {            	
				
			}
		});
	});
	
	$(document).on("click", ".viewPicture", function() {		
		var path = $(this).attr("path");		
		$("#ZoomPik #viewZoomPicture").attr("src",path);		
	});
	
	$(document).on("click", ".sharePicToUser", function() {
		var userId = $(this).attr("userId");
		var resourceId = $(this).attr("picId");
		
		// ajax request start here
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/myapps/shareResource',
			type: 'POST',
			data: {resourceId:resourceId,shareTo:userId,resourceType:"picture"},
			success: function(data) 
			{
			$('#hiddenjournalid').val('');
				location.reload();
			}
		});
	});
	
});