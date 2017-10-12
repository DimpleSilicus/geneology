

/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@name		   : getUserList
 *@description : function to get User list data 
 */

function getUserList()
{	 	
	var userType = ''; // variable for user type
	var changeStatus = ''; // variable for show user current status
	
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url:'userList',
				type:'get',
				dataType:'json',
				success: function(data) {

						$.each(data,function(key,value) {
							
						if(value.type=='0')
							{
							userType = 'Free Member';
							}
						else
							{
							userType = 'Paid Member';
							}
						
						if(value.status=='0')
							{
								changeStatus = 'Reactivate';
							}
						else
							{
								changeStatus = 'Deactivate';
							}
						
						$('#searchUserResultTable tbody').append('<tr id="resultRow"><td>'+value.username+'</td><td>'+value.email+'</td><td>'+userType+'</td><td><a onclick="changeUserStatus('+value.id+','+value.status+')" style="cursor: pointer;" class="table-icon">'+changeStatus+'</a></td><td><a  data-toggle="modal" data-target="#Subscription"  onclick="GetSubscription('+value.id+')" style="cursor: pointer;" class="table-icon">Subscription</a></td></tr>');       
						});	
								
				}
			}); 
}



/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@name 	   : searchUserDetails
 *@description : function to get search User data 
 */
function searchUserDetails()
{	 
		var userType = ''; // variable for user type
		var changeStatus = ''; // variable for show user current status
		var searchKey = $('#SearchName1').val();
		
    	$("#searchname1-div").removeClass("has-error");
    	$('#form-errors-searchname1').html();

			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: 'searchUser',
				type:'POST',
				data:{search:searchKey},
				success: function(data) {
					
					if(data==false)
					{
					    $('#searchUserResultTable tbody').append('<tr><td colspan=2><strong>No Search Result Found</strong></td></tr>');						
					}
					else
					{
						$.each(data, function(key,value) {	
							
							
							if(value.type=='0')
							{
							userType = 'Free Member';
							}
						else
							{
							userType = 'Paid Member';
							}
						
						if(value.status=='0')
							{
								changeStatus = 'Reactivate';
							}
						else
							{
								changeStatus = 'Deactivate';
							}	
							
						$('#searchUserResultTable tbody').append('<tr id="resultRow"><td>'+value.username+'</td><td>'+value.email+'</td><td>'+userType+'</td><td><a onclick="changeUserStatus('+value.id+','+value.status+')" style="cursor: pointer;" class="table-icon">'+changeStatus+'</a></td><td><a  data-toggle="modal" data-target="#EditTutorial"  onclick="editTutorial('+value.id+')" style="cursor: pointer;" class="table-icon">Subscription</a></td></tr>');       						});	
					}
					
				},
				error: function(data) {   
					// validation message for validation
					var obj = jQuery.parseJSON(data.responseText);    		
	        		if (obj.search) {
		            	$("#searchname1-div").addClass("has-error");
		            	$('#form-errors-searchname1').html(obj.search);
		            }      		      
				}
			}); 
				
}


/**
 * @author      : Swapnil Patil <swapnilj.patil@silicus.com>
 * @name		: changeUserStatus
 * @description : function to update User status (Active/Deactive) 
 */
  
function changeUserStatus(id,status)
{	
	var userId  = id;
	var userStatus = status;
	
	BootstrapDialog.confirm({
        title: 'CONFIRM',
        message: 'Are you sure you want to change user status?',
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
			url: 'updateUserStatus',
			type: 'post',
			data: {id:userId,status:userStatus},
			success: function(data) 
			{
			location.reload();		
			},
			error: function(data) {  
        		var obj = jQuery.parseJSON(data.responseText);        		        		      
	        }
		  }); 
		
		//getUserList();
        } else {
            return false;
        }
    }
	});
}
	

/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@name		   : getTutorialList
 *@description : function to get tutorial data 
 */

function getTutorialList()
{	 	
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url:'tutorialList',
				type:'get',
				dataType:'json',
				success: function(data) {

						$.each(data,function(key,value) {	
						$('#searchResultTable tbody').append('<tr id="resultRow"><td>'+value.question+'</td><td><a  data-toggle="modal" data-target="#EditTutorial"  onclick="editTutorial('+value.id+')" style="cursor: pointer;" class="table-icon"><i class="fa fa-pencil"></i></a></td></tr>');       
						});	
								
				}
			}); 
}


/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@name 	   : AddNewTutorial
 *@description : function to Add New Tutorial 
 */
function AddNewTutorial()
{	
	getTutorialList();
	var IdQuestion = $('#Question').val();
	var IdAnswer   = $('#Answer').val();

    	$("#Question-div").removeClass("has-error");
    	$('#form-errors-Question').html();
	
    	$("#Answer-div").removeClass("has-error");
    	$('#form-errors-Answer').html();
    	
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: 'addTutorial',
			type: 'POST',
			data: {question:IdQuestion,answer:IdAnswer},
			success: function(data) 
			{
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
 *@name        : searchUserQueries
 *@description : function to search tutorial data 
 */

function searchUserQueries()
{	 
		var searchKey = $('#SearchName').val();
		
    	$("#searchname-div").removeClass("has-error");
    	$('#form-errors-searchname').html();
		
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
						$('#searchResultTable tbody').append('<tr id="resultRow"><td>'+value.question+'</td><td><a  data-toggle="modal" data-target="#EditTutorial"  onclick="editTutorial('+value.id+')" style="cursor: pointer;" class="table-icon"><i class="fa fa-pencil"></i></a></td></tr>');       
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
*@name 		  : editTutorial
*@description : function to edit existing tutorial 
*/

function editTutorial(id)
{
var getId = id;
$.ajax({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	url: 'editTutorial',
	type: 'get',		
	data: {id:getId},
	success: function(data) 
	{ 
		$('#Question1').val(data.question);
		$('#Answer1').val(data.answer);
		$('#TutorialId').val(data.id);
	}
}); 

}

/**
 * @author      : Swapnil Patil <swapnilj.patil@silicus.com>
 * @name 		: UpdateTutorial
 * @description : function to update existing tutorial 
 */
  
function UpdateTutorial()
{	
	
	var idQuestion  = $('#Question1').val();
	var idAnswer 	= $('#Answer1').val();
	var tutorialId  = $('#TutorialId').val();
	
	
	$("#UploadPik #filename-div").removeClass("has-error");
	$('#UploadPik #form-errors-filename').html("");
	
    	$("#Question-div1").removeClass("has-error");
    	$('#form-errors-Question1').html();
   

    	$("#Answer-div1").removeClass("has-error");
    	$('#form-errors-Answer1').html();
    
	
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: 'updateTutorial',
			type: 'POST',
			data: {question:idQuestion,answer:idAnswer,id:tutorialId},
			success: function(data) 
			{
			$('#Question1').val('');
			$('#Answer1').val('');
			$('#TutorialId').val('');
			$('#EditTutorial').modal('hide');
			location.reload();		
			},
			error: function(data) {  
        		var obj = jQuery.parseJSON(data.responseText);        		

        		if (obj.question) {
	            	$("#Question-div1").addClass("has-error");
	            	$('#form-errors-Question1').html(obj.question);
	            }
        		
        		if (obj.answer) {
	            	$("#Answer-div1").addClass("has-error");
	            	$('#form-errors-Answer1').html(obj.answer);
	            }
        		      
	        }
		}); 
		
}

/**  
*@author      : Dimple Agarwal <dimple.agarwal@silicus.com>
*@name 		  : GetSubscription
*@description : function to show subscription plan(s) of user.
*/

function GetSubscription(id)
{
    
    var getId = id;

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'GetSubscription',
        type: 'get',
        data: {id: getId},
        success: function (data)
        {
            console.log(JSON.stringify(data));
            
            $('#SubscriptionTable tbody').html('');
            if(data==false)
            {
                $('#SubscriptionTable tbody').append('<tr><td colspan=6 style="text-align: center;"><strong>No Subscripiton Found</strong></td></tr>');						
            }
            else
            {
                $.each(data,function(key,value) {                
                    $('#SubscriptionTable tbody').append('<tr id="resultRow"><td>'+value.name+'</td><td>'+value.description+'</td><td>'+value.amount+'</td><td>'+value.gedcom+'</td><td>'+value.transaction_date+'</td><td>'+value.transaction_id+'</td></tr>');       
                });
            }
        }
    }); 

}


getUserList();	
getTutorialList();	


/**
 * @author      : Swapnil Patil <swapnilj.patil@silicus.com>
 * @description : function call to searchUserQueries() on click event of search button
 */
$(document).ready( function() {
	
$('#idSearch').on('click', function() {
	$('#searchResultTable tbody').empty();
	searchUserQueries();
});	


$('#idSearchUser').on('click', function() {
	$('#searchUserResultTable tbody').empty();
	searchUserDetails();
});	


});

