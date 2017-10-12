
 /** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to Search Resource Details 
 */
function searchResource()
{	
	var IdResourceName  = $('#ResourceName').val();
	var IdResourcePlace	= $('#ResourcePlace').val();
	var IdResourceYear 	= $('#ResourceYear').val();
	var IdGenerationGap = $('#GenGap').val();
	
    	$("#ResourceName-div").removeClass("has-error");
    	$('#form-errors-ResourceName').html();
    	
        $("#ResourcePlace-div").removeClass("has-error");
        $('#form-errors-ResourcePlace').html();
       	
		$("#ResourceYear-div").removeClass("has-error");
        $('#form-errors-ResourceYear').html();

        $("#GenerationGap-div").removeClass("has-error");
       	$('#form-errors-GenerationGap').html();
    	
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/resource-app/search',
			type: 'POST',
			data: {ResourceName:IdResourceName,ResourcePlace:IdResourcePlace,ResourceYear:IdResourceYear,GenerationGap:IdGenerationGap},
			success: function(data) 
			{

				if(data==false)
				{
				    $('#searchResourceResult tbody').append('<tr><td colspan=2><strong>No Search Result Found</strong></td></tr>');						
				}
				else
				{
					$.each(data, function(key,value) {	
					$('#searchResourceResult tbody').append('<tr id="resultRow"><td>'+value.first_name+' '+value.last_name+'</td><td><a data-toggle="modal" data-target="#viewDescription" style="cursor: pointer;" onclick="getFamilydetails('+value.user_id+')">View Details</a></td></tr>');       						});	
				}			
				
				
			},
			error: function(data) {  
        		var obj = jQuery.parseJSON(data.responseText);        		

        		if (obj.ResourceName) {
	            	$("#ResourceName-div").addClass("has-error");
	            	$('#form-errors-ResourceName').html(obj.ResourceName);
	            }
        		
        		if (obj.ResourcePlace) {
	            	$("#ResourcePlace-div").addClass("has-error");
	            	$('#form-errors-ResourcePlace').html(obj.ResourcePlace);
	            }
        		
        		if (obj.ResourceYear) {
	            	$("#ResourceYear-div").addClass("has-error");
	            	$('#form-errors-ResourceYear').html(obj.ResourceYear);
	            }
        		
        		if (obj.GenerationGap) {
	            	$("#GenerationGap-div").addClass("has-error");
	            	$('#form-errors-GenerationGap').html(obj.GenerationGap);
	            }
      
	        }
		}); 
}


/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to delete queue
*/
function deleteQueue(id)
{
	var queueId = id; 
	
	BootstrapDialog.confirm({	
		title: 'CONFIRM',
		message: 'Are you sure you want to delete this queue?',
		type: BootstrapDialog.TYPE_DANGER, 
		closable: true, 
		draggable: true,
		btnCancelLabel: 'Cancel', 
		btnOKLabel: 'Ok', 
		btnOKClass: '', 
		callback: function (result) 
		{
			// result will be true if button was click, while it will be false if users close the dialog directly.
			if (result) 
				{
					$.ajax({
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							url: '/resource-app/deleteQueue',
							type: 'POST',
							data: {id:queueId},
							success: function(data) 
							{
								location.reload();

							}
					});
				} 
			else 
			{
				return false;
			}
		
		}
	});
	
}




/** 
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to get Family Details 
*/
function getFamilydetails(id)
{	
	var familyId  = id;

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/resource-app/getFamily',
			type: 'get',
			data: {id:familyId},
			success: function(data) 
			{			
				
			var fullname = data.first_name+' '+data.last_name;	
            $('#memberName').text(fullname);
            $('#generGap').text(data.generation);
            $('#gender').text(data.gender);
            $('#notes').text(data.notes);
            $('#place').text(data.place);
            $('#birthDate').text(data.bdate);
	        }
		}); 
}




$(document).ready( function() {
		
/**
* @author      : Swapnil Patil <swapnilj.patil@silicus.com>
* @description : function call to searchResource() on click of search button
*/	
$('#serchQueueBtn').on('click', function() {
	$('#searchResourceResult tbody').empty();
	searchResource();
});	


/**
* @author      : Swapnil Patil <swapnilj.patil@silicus.com>
* @description : Clear all search fields on click of cancle button
*/
$('#cancleBtn').on('click', function() {
	$('#ResourceName').val('');
	$('#ResourcePlace').val('');
	$('#ResourceYear').val('');
	$('#GenGap').val('');
});	


/** 
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : Add New Queue Details 
*/
var formAddQueue = $("#frmAddQueue");

formAddQueue.submit(function(e) {
e.preventDefault();

var IdQueDescrp     = $('#QueDescrp').val();
var IdUploadFile	= $('#FileUpload').prop('files')[0];
var formData = new FormData(this);

formData.append('file', IdUploadFile);
formData.append('Description', IdQueDescrp);

$("#frmAddQueue #QueDescrp-div").addClass("has-error");
$('#frmAddQueue #form-errors-QueDescrp').html("");

$("#UploadFile-div").addClass("has-error");
$('#form-errors-UploadFile').html("");

$.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	url: '/resource-app/addQueue',
	type: 'POST',
	data: formData,
    processData: false,
    contentType: false,
	success: function(data) 
	{
	location.reload();			
	$('#QueDescrp').val('');
	$('#FileUpload').val('');
	},
	error: function(data) {  
	
	console.log(data.responseText);
    var obj = jQuery.parseJSON(data.responseText);
		
	if (obj.FileUpload) {
    	$("#frmAddQueue #UploadFile-div").addClass("has-error");
    	$('#frmAddQueue #form-errors-UploadFile').html(obj.FileUpload);
    }
    
    if (obj.Description) {
        	$("#frmAddQueue #QueDescrp-div").addClass("has-error");
        	$('#frmAddQueue #form-errors-QueDescrp').html(obj.Description);
        }

	}
}); 
return false;
});

	
});  // jquery close here
