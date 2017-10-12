 /** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to Add New Events 
 */
function AddNewEvent()
{	
	var IdEventName = $('#EventName').val();
	var IdEventDate = $('#EventDate').val();
	var IdEventPlace = $('#EventPlace').val();
	
	$("#EventName-div").removeClass("has-error");
	$('#form-errors-EventName').html("");
	
	$("#EventDate-div").removeClass("has-error");
	$('#form-errors-EventDate').html("");
	
	$("#EventPlace-div").removeClass("has-error");
	$('#form-errors-EventPlace').html("");
	
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/event-app/addEvent',
			type: 'POST',
			data: {Eventname:IdEventName,Date:IdEventDate,Place:IdEventPlace},
			success: function(data) 
			{
			console.log('data inserted successfully');
			$('#EventName').val('');
			$('#EventDate').val('');
			$('#EventPlace').val('');
			$('#AddEvent').modal('hide');
			location.reload();
			},
			error: function(data) {  
        		var obj = jQuery.parseJSON(data.responseText);        		

        		if (obj.Eventname) {
	            	$("#EventName-div").addClass("has-error");
	            	$('#form-errors-EventName').html(obj.Eventname);
	            }
        		
        		if (obj.Date) {
	            	$("#EventDate-div").addClass("has-error");
	            	$('#form-errors-EventDate').html(obj.Date);
	            }
        		
        		if (obj.Place) {
	            	$("#EventPlace-div").addClass("has-error");
	            	$('#form-errors-EventPlace').html(obj.Place);
	            }
      
	        }
		}); 
}


/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to edit existing events 
*/

function editEvent(id)
{
var getId = id;
$.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	url: '/event-app/editEvent',
	type: 'get',		
	data: {id:getId},
	success: function(data) 
	{ 
		$('#fieldEventName').val(data.name);
		$('#fieldEventDate').val(data.event_date);
		$('#fieldEventPlace').val(data.place);
		$('#EventId').val(data.id);
	}
}); 

}



/**
 * @author      : Swapnil Patil <swapnilj.patil@silicus.com>
 * @description : function to update existing events 
 */
  
function UpdateEvents()
{	

	var IdEvent = $('#EventId').val();	
	var IdEventName = $('#fieldEventName').val();
	var IdEventDate = $('#fieldEventDate').val();
	var IdEventPlace = $('#fieldEventPlace').val();
	
	$("#EventName-div2").removeClass("has-error");
	$('#form-errors-EventName2').html("");
	
	$("#EventDate-div2").removeClass("has-error");
	$('#form-errors-EventDate2').html("");
	
	$("#EventPlace-div2").removeClass("has-error");
	$('#form-errors-EventPlace2').html("");
	
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/event-app/updateEvent',
			type: 'POST',
			data: {Eventname:IdEventName,Date:IdEventDate,Place:IdEventPlace,id:IdEvent},
			success: function(data) 
			{
			console.log('data inserted successfully');
			$('#fieldEventName').val('');
			$('#fieldEventDate').val('');
			$('#fieldEventPlace').val('');
			$('#EventId').val('');
			$('#EditEvent').modal('hide');
			location.reload();
			$('#Resource_Queue').show();
			},
			error: function(data) {  
        		var obj = jQuery.parseJSON(data.responseText);        		

        		if (obj.Eventname) {
	            	$("#EventName-div2").addClass("has-error");
	            	$('#form-errors-EventName2').html(obj.Eventname);
	            }
        		
        		if (obj.Date) {
	            	$("#EventDate-div2").addClass("has-error");
	            	$('#form-errors-EventDate2').html(obj.Date);
	            }
        		
        		if (obj.Place) {
	            	$("#EventPlace-div2").addClass("has-error");
	            	$('#form-errors-EventPlace2').html(obj.Place);
	            }
      
	        }
		}); 
}
	

/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to get existing event details for share on network 
*/

function getEventsOnNetwork(id)
{
var getId = id;
$.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	url: '/event-app/getEventOnNetwork',
	type: 'get',		
	data: {id:getId},
	success: function(data) 
	{ 
		$('#EventRowId').val(data.id);
		shareEventOnMyNetwork();
	}
}); 

}


/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to delete events
*/
function deleteEvent(id)
{
	var eventId = id; 
	
	BootstrapDialog.confirm({	
		title: 'CONFIRM',
		message: 'Are you sure you want to delete this event?',
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
							url: '/event-app/deleteEvent',
							type: 'POST',
							data: {id:eventId},
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
*@description : function to share Events On My Network
*/
function shareEventOnMyNetwork()
{
 var eventId = $('#EventRowId').val();	
 $.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		url: '/event-app/shareEventOnNetwork',
		type: 'POST',
		data: {resourceId:eventId},
		success: function(data) 
		{
		console.log('data inserted successfully');
		$('#EventRowId').val('');
		location.reload();
		}
	}); 
}


/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to get single event details
*/

function getSingleEvents(id,shareid)
{
var getId = id;
var shareId = shareid;
$('#SharedId').val(shareId);

$.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	url: '/event-app/getSingleEvent',
	type: 'get',		
	data: {id:getId},
	success: function(data) 
	{ 
		$('#EventRowId').val(data.id);
		shareEventPersonnely();
	}
}); 

}


/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to share Events Personnely with network member
*/
function shareEventPersonnely()
{
 var eventId = $('#EventRowId').val();	
 var SharedId = $('#SharedId').val();
 
 $.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		url: '/event-app/shareEventsPersonnely',
		type: 'POST',
		data: {resourceId:eventId,shareTo:SharedId},
		success: function(data) 
		{
		console.log('data inserted successfully');
		$('#EventRowId').val('');
		location.reload();
		}
	}); 
}


