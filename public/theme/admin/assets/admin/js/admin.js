 /** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to Add New Tutorial 
 */
function AddNewTutorial()
{	
	var IdQuestion = $('#Question').val();
	var IdAnswer   = $('#Answer').val();

		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: 'addTutorial',
			type: 'POST',
			data: {question:IdQuestion,answer:IdAnswer},
			success: function(data) 
			{
			console.log('data inserted successfully');
			$('#Question').val('');
			$('#Answer').val('');
			$('#AddTuots').modal('hide');
			location.reload();
			},
			error: function(data) {  
        		var obj = jQuery.parseJSON(data.responseText);        		

        		if (obj.question) {
	            	$("#Question-div").addClass("has-error");
	            	$('#form-errors-Question').html(obj.question);
	            }
        		
        		if (obj.answer) {
	            	$("#Answer-div").addClass("has-error");
	            	$('#form-errors-Answer').html(obj.answer);
	            }
        		      
	        }
		}); 
}


/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to search tutorial app data 
 */

getTutorialList();

function getTutorialList()
{	 	
		
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: 'list',
				type:'get',
				dataType:'json',
				success: function(data) {
					
					if(data==false)
					{
					
					    $('#searchResultTable tbody').append('<tr><td colspan=2><strong>No Search Result Found</strong></td></tr>');						
					}
					else
					{
						$.each(data, function(key,value) {	
						$('#searchResultTable tbody').append('<tr id="resultRow"><td>'+value.question+'</td><td><a href="#" class="table-icon"><i class="fa fa-pencil"></i></a></td></tr>');       
						});	
					}
					
				}
			}); 
				
}


/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to search tutorial app data 
 */

searchUserQueries();

function searchUserQueries()
{	 	
		var searchKey = $('#SearchName').val();
				
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: 'search',
				type:'POST',
				data:{search:searchKey},
				success: function(data) {
					
					if(data==false)
					{
					
					    $('#searchResultTable tbody').append('<tr><td colspan=2><strong>No Search Result Found</strong></td></tr>');						
					}
					else
					{
						$.each(data, function(key,value) {	
						$('#searchResultTable tbody').append('<tr id="resultRow"><td>'+value.question+'</td><td><a href="#" class="table-icon"><i class="fa fa-pencil"></i></a></td></tr>');       
						});	
					}
					
				},
				error: function(data) {   
					// validation message for validation
					var obj = jQuery.parseJSON(data.responseText);    		
	        		if (obj.search) {
		            	$("#searchname-div").addClass("has-error");
		            	$('#form-errors-searchname').html(obj.search);
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
	