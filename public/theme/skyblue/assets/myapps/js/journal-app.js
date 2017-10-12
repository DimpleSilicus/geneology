 /** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to Add New Journal 
 */
	function AddNewJournal()
	{	
		var journalName = $('#JournalTitle').val();
		var journalDescription = $('#JournalDescrp').val();
		var journal_id = $('#idhidden').val();
		
		
		$("#name-div").removeClass("has-error");
    	$('#form-errors-name').html("");
    	
    	$("#description-div").removeClass("has-error");
    	$('#form-errors-description').html("");
		
								$.ajax({
								headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
								url: '/journal-app/addJournal',
								type: 'POST',
								data: {title:journalName ,description: journalDescription},
								success: function(data) 
								{
								$('#JournalTitle').val('');
								$('#JournalDescrp').val('');
								$('#idhidden').val('');
								$('#AddJournal').modal('hide');
								location.reload();
								},
								error: function(data) {  
									var obj = jQuery.parseJSON(data.responseText);        		

									if (obj.title) {
										$("#name-div").addClass("has-error");
										$('#form-errors-name').html(obj.title);
									}
									
									if (obj.description) {
										$("#description-div").addClass("has-error");
										$('#form-errors-description').html(obj.description);
									}
						  
								}
							}); 
			
	}

	/**  
	*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
	*@description : function to edit existing journal 
	*/

	function editJournal(id)
	{
		var getId = id;
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/journal-app/editJournal',
			type: 'get',		
			data: {id:getId},
			success: function(data) 
			{ 
				$('#JournalTitle1').val(data.name);
				$('#JournalDescrp1').val(data.description);
				$('#idhidden').val(data.id);
			}
		}); 
		
	}

	 /**
	 * @author      : Swapnil Patil <swapnilj.patil@silicus.com>
	 * @description : function to update existing journal 
	 */
	  
		

	function UpdateJournal()
	{	
		var journalName = $('#JournalTitle1').val();
		var journalDescription = $('#JournalDescrp1').val();
		var journalId = $('#idhidden').val();
		
		$("#name-div1").removeClass("has-error");
    	$('#form-errors-name1').html("");
    	
    	$("#description-div1").removeClass("has-error");
    	$('#form-errors-description1').html("");
		
						// ajax request start here
						$.ajax({
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							url: '/journal-app/updateJournal',
							type: 'POST',
							data: {title:journalName,description:journalDescription,id:journalId},
							success: function(data) 
							{
							$('#JournalTitle').val('');
							$('#JournalDescrp').val('');
							$('#idhidden').val('');
							$('#EditJournal').modal('hide');
							location.reload();
							},
							error: function(data) {  
								var obj = jQuery.parseJSON(data.responseText);        		

								if (obj.title) {
									$("#name-div1").addClass("has-error");
									$('#form-errors-name1').html(obj.title);
								}
								
								if (obj.description) {
									$("#description-div1").addClass("has-error");
									$('#form-errors-description1').html(obj.description);
								}
					  
							}
						}); 
						// ajax request close here
	}				



	 /**
	 * @author      : Swapnil Patil <swapnilj.patil@silicus.com>
	 * @description : function to delete existing journal 
	 */
	function deleteJournal(id)
	{
		var journalId = id; 
		
		BootstrapDialog.confirm({	
			title: 'CONFIRM',
			message: 'Are you sure you want to delete this journal?',
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
								url: '/journal-app/deleteJournal',
								type: 'POST',
								data: {id:journalId},
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
	*@description : function to get existing journal details
	*/

	function getJournalOnNetwork(id)
	{
	var getId = id;
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		url: '/journal-app/getJournalOnNetwork',
		type: 'get',		
		data: {id:getId},
		success: function(data) 
		{ 
			$('#resourceType').val('journal');
			$('#hiddenjournalid').val(data.id);
			shareJournalOnMyNetwork();
		}
	}); 

	}


	/**  
	*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
	*@description : function to share Journal On My Network
	*/
	function shareJournalOnMyNetwork()
	{
		
		var journalid = $('#hiddenjournalid').val();	
		 
			// ajax request start here
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/journal-app/shareJournalOnNetwork',
				type: 'POST',
				data: {resourceId:journalid},
				success: function(data) 
				{
				$('#hiddenjournalid').val('');
				location.reload();
				}
			}); 
			// ajax request end here	
					
	}



	/**  
	*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
	*@description : function to get personnel Journal details
	*/

	function getSingleJournalDetails(id,shareid)
	{
	var getId = id;
	var shareId = shareid; 
	$('#SharedId').val(shareId);
    
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		url: '/journal-app/getSingleJournal',
		type: 'get',		
		data: {id:getId},
		success: function(data) 
		{ 
			$('#hiddenjournalid').val(data.id);
			shareJournalPersonnely();
		}
	}); 

	}


	/**  
	*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
	*@description : function to share Journal Personnely with network member
	*/
	function shareJournalPersonnely()
	{
		var JournalId = $('#hiddenjournalid').val();	
		var SharedId = $('#SharedId').val();
 
						// ajax request start here
						$.ajax({
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							url: '/journal-app/shareJournalsToUser',
							type: 'POST',
							data: {resourceId:JournalId,shareTo:SharedId},
							success: function(data) 
							{
							$('#hiddenjournalid').val('');
							location.reload();
							}
						});
						// ajax request end here	
			
	}
	
	
	/**  
	*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
	*@description : function to get user privacy settings for Modules
	*/

	 getJournalPrivacySettings();
	
	function getJournalPrivacySettings()
	{
		    
	$.ajax({  // 1
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		url: '/journal-app/getPrivacySettings',
		type: 'get',		
		data: {},
		success: function(data) 
		{ 
			$.each(data , function(key,value) {	 // 2	
				
				var userID 					= value.user_id;
				var parseData 				= JSON.parse(value['journals']);
				var setPublic 				= parseData.public; 
				var setCloseFamily  		= parseData.closeFamily; 
				var setRelative  			= parseData.relative; 
				var setResearchConnection   = parseData.researchConnection; 
				var setNobody  				= parseData.nobody; 
						
				  
				/*	$('ul #llist').each(function(i) {
						
						var listItem = $(this).attr('liId'); 
						
						// to get journal owner
						var journalOwner  = listItem.substring(0, listItem.indexOf(','));
						//alert(journalOwner);
						
						// to get network users
						var ddd  = listItem.substring(listItem.indexOf(",") + 1);
						var networkUserId  = ddd.substring(0, ddd.indexOf(','));
						//alert(userNetwork);
						
						// to get user relation
						var userRelation = listItem.substring(listItem.lastIndexOf(",") + 1); 
						//alert(userRelation);
						
						// to get journal no
						var jrNo = listItem.split(','),
					    journalNo = jrNo[jrNo.length-2];
						//alert(journalNo);
						
						var newRowid = '#jorrnalRow_'+journalNo;
						
						
						if(userID==journalOwner)
						{
							$(newRowid).show();
						}
						else
							{
		
								if(userRelation=='closeFamily' && networkUserId==journalOwner && setCloseFamily=='1')
								{
									$(newRowid).show();
								}	
														
								else if(userRelation=='relative' && networkUserId==journalOwner && setRelative=='1')
								{
									$(newRowid).show();
								}						
								
								else if(userRelation=='researchConnection' && networkUserId==journalOwner && setResearchConnection=='1')
								{
									$(newRowid).show();
								}
								
								else if(userRelation=='public' && networkUserId==journalOwner && setPublic=='1')
								{
									$(newRowid).show();
								}
						}
										
					});  */
					
					
					
			});  // 2
			
		}
	});  // 1

	}
