/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to get tutorial data 
 */

getTutorialList();

function getTutorialList()
{	 	
		
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/tutorial-app/tutorialList',
				type:'get',
				dataType:'json',
				success: function(data) {

						$.each(data, function(key,value) {	
						$('#searchResultDiv').append('<div id="resultSet" class="row"><div class="col-sm-12"><strong>'+value.question+'</strong><br/><div class="more">'+value.answer+'</div></div></div><div class="row"><div class="col-sm-12"><div class="border-bttm-dashed margin-T-20"></div></div></div>');							        
						});	
								
				}
			}); 
				
} 


/** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to search tutorial app data 
 */

function searchUserQueries()
{	 
		var searchKey = $('#SearchName').val();
		$('#searchResultDiv').empty();	
		
    	$("#searchname-div").removeClass("has-error");
    	$('#form-errors-searchname').html();
		
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/tutorial-app/search',
				type:'post',
				data:{search:searchKey},
				success: function(data) {
					
                                        $('#searchResultDiv').html('');
					if(data==false)
					{
					    $('#searchResultDiv').append('<div id="resultSet" class="row"><div class="col-sm-12"><strong>No Search Result Found</strong><br/>Please Try Again</div></div><div class="row"><div class="col-sm-12"><div class="border-bttm-dashed margin-T-20"></div></div></div>');						
					}
					else
					{
						$.each(data, function(key,value) {
						$('#searchResultDiv').append('<div id="resultSet" class="row"><div class="col-sm-12"><strong>'+value.question+'</strong><br/><div class="more">'+value.answer+'</div></div></div><div class="row"><div class="col-sm-12"><div class="border-bttm-dashed margin-T-20"></div></div></div>');							        
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
 * @author      : Swapnil Patil <swapnilj.patil@silicus.com>
 * @description : function call to searchUserQueries() on click event of search button
 */
$(document).ready( function() {
	
$('#idSearch').on('click', function() {
	$('#searchResultDiv').empty();
	searchUserQueries();
});	


$('#SearchName').on('keypress', function() {
	$('#searchResultDiv').empty();
	searchUserQueries();
});	


	
});