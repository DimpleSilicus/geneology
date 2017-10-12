$(document).ready(function () {
	var addPepoleForm = $("#frmAddPepole");
	addPepoleForm.submit(function(e) {
		e.preventDefault();		
		var formData = addPepoleForm.serialize();
		
		$("#addPepoleModal #genName").val("");
		$("#addPepoleModal #personDate").val("");
		
		$("#addPepoleModal #genName-div").removeClass("has-error");
     	$('#addPepoleModal #form-errors-genName').html('');
 	
        $("#addPepoleModal #personRelation-div").removeClass("has-error");
     	$('#addPepoleModal #form-errors-personRelation').html('');
 	
        $("#addPepoleModal #personFamily-div").removeClass("has-error");
     	$('#addPepoleModal #form-errors-personFamily').html('');
 
	    $("#addPepoleModal #personEvents-div").removeClass("has-error");
        $('#addPepoleModal #form-errors-personEvents').html('');
        
        $("#addPepoleModal #eventRows").html('');
        
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/gedcom/pepole/add',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	$("#addPepoleModal").modal('hide');
	        	location.reload(); 
	        },
	        error: function(data) {      
	        		var obj = jQuery.parseJSON(data.responseText);	   
		        	 if (obj.genName) {
			        	$("#addPepoleModal #genName-div").addClass("has-error");
		            	$('#addPepoleModal #form-errors-genName').html(obj.genName);
		        	 }
		        	 if (obj.personRelation) {
			        	$("#addPepoleModal #personRelation-div").addClass("has-error");
		            	$('#addPepoleModal #form-errors-personRelation').html(obj.personRelation);
		        	 }
		        	 if (obj.personFamily) {
			        	$("#addPepoleModal #personFamily-div").addClass("has-error");
		            	$('#addPepoleModal #form-errors-personFamily').html(obj.personFamily);
		        	 }
		        	 if (obj.eventRowsValues) {
				        	$("#addPepoleModal #personEvents-div").addClass("has-error");
			            	$('#addPepoleModal #form-errors-personEvents').html(obj.eventRowsValues);
			        }
	        }
	    });
	});
	
	var addFamilyForm = $("#frmAddFamily");
	addFamilyForm.submit(function(e) {
		e.preventDefault();		
		var formData = addFamilyForm.serialize();
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/gedcom/family/add',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	$("#addFamilyModal").modal('hide');	        	
	        	location.reload(); 
	        },
	        error: function(data) {      
	        		var obj = jQuery.parseJSON(data.responseText);	   
		        	 if (obj.familyName) {
			        	$("#addFamilyModal #famName-div").addClass("has-error");
		            	$('#addFamilyModal #form-errors-famName').html(obj.familyName);
		        	 }
	        }
	    });
	});
	
	
	function addPersonRow(personDate,personEvent,personPlace,rowValue){
		
		var newPersonEvent = personEvent.charAt(0).toUpperCase() + personEvent.slice(1);
		var personPlace = personPlace.charAt(0).toUpperCase() + personPlace.slice(1);
		var row = '<div class="row margin-T-10"><div class="col-sm-4 col-xs-12"><label class="has-label-info"><strong>'+personDate+'</strong></label></div><div class="col-sm-4 col-xs-12"><label class="has-label-info"><strong>'+ newPersonEvent+'</strong></label></div><div class="col-sm-3 col-xs-9"><label class="has-label-info"><strong>'+personPlace+'</strong></label></div><div class="col-sm-1 col-xs-3"><a href="#" class="modal-icon" ><i class="fa fa-trash modal-ico-plus" rowEvnt='+personEvent+' rowVal='+rowValue+'></i></a></div><div class="col-sm-11 col-xs-11 border-bttm margin-LR-15"></div>';
		return row;
	}
	
	$(document).on("click", ".addPepole-ico-plus", function() {
		manageEvent("#addPepoleModal");
	});
	
	$(document).on("click", ".editPepole-ico-plus", function() {
		
		manageEvent("#editPepoleModal");
	});
	
	$(document).on("click", ".fa-trash", function() {
		var currentModal = $('.modal.fade.in').attr('id')
		
		var eventRowsData = $("#"+currentModal+" #eventRowsData").val();
		var eventRowsValues = $("#"+currentModal+" #eventRowsValues").val();
		var eventRowToRemove = $(this).attr("rowval");
		var eventToRemove = $(this).attr("rowEvnt");
		
		var newData = removeVal(eventRowsValues,eventRowToRemove )
		
		$("#"+currentModal+" #eventRowsValues").val(newData);
		
		var newVal = removeVal(eventRowsData,eventToRemove )
	
		$("#"+currentModal+" #eventRowsData").val(newVal);		
		
		$(this).parent().parent().parent().remove();
	});
	
	function manageEvent(modalName){
		if('' == $(modalName+" #personDate").val()) return false;
		var eventRowsData =  $(modalName+" #eventRowsData").val();
		var eventRowsValue =  $(modalName+" #eventRowsValues").val();
		
		var hiddenIds = eventRowsData.split(',');
		
		var personDate = $(modalName+" #personDate").val();
		var personDateType = $(modalName+" #personDateType option:selected").text();
		var personDateTypeVal = $(modalName+" #personDateType").val();
		var personPlace = $(modalName+" #personPlace").val();				
		var rowsValues = personDate+'_'+personDateTypeVal+'_'+personPlace;
		
		var row = addPersonRow(personDate,personDateType,personPlace,rowsValues);
		
		if ($.inArray(personDateType, hiddenIds) !== -1) {
		    return false;
		}else{
			$(modalName+" #eventRows").append(row);
			
			if('' != eventRowsData){
				var newData = eventRowsData+','+personDateType;
			}else{
				var newData = personDateType;
			}			
			
			if('' != eventRowsValue){
				var newValues = eventRowsValue+','+rowsValues;
			}else{
				var newValues = rowsValues;
			}	
			
			$(modalName+" #eventRowsData").val(newData);
			$(modalName+" #eventRowsValues").val(newValues);			
		}		
	}
	
	$(document).on("click", "#addPepoleModal", function() {		
		var generation  = $("#gnhTabContent").find(".active").attr('id')
		$("#addPepoleModal #generation").val(generation);
	});
	
	$(document).on("click", ".editPepole", function() {		
		
		var mid = $(this).attr('mid');
		
       	$("#editPepoleModal #genName-div").removeClass("has-error");
     	$('#editPepoleModal #form-errors-genName').html('');
 	
        $("#editPepoleModal #personRelation-div").removeClass("has-error");
     	$('#editPepoleModal #form-errors-personRelation').html('');
 	
        $("#editPepoleModal #personFamily-div").removeClass("has-error");
     	$('#editPepoleModal #form-errors-personFamily').html('');
 
	    $("#editPepoleModal #personEvents-div").removeClass("has-error");
        $('#editPepoleModal #form-errors-personEvents').html('');
        
        $("#editPepoleModal #eventRows").html('');
        
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/gedcom/pepole/edit',
	        type: 'POST',
	        data: {mid:mid},
	        success: function(data) {
	        	$("#editPepoleModal").modal('show');	        
	        	
	        	$("#editPepoleModal #memId").val(mid);
	        	$("#editPepoleModal #genName").val(data['info'][0].first_name);
	        	$("#editPepoleModal #personFamily").val(data['info'][0].family_id);
	        	$("#editPepoleModal #personRelation").val(data['info'][0].relation);
	        	
	        	var eventTypeList = '';
	        	var eventList = '';
	        	
	        	$.each(data["events"], function( index, value ) {	
	        		if('' == eventTypeList){
	        			eventTypeList = value.name;
	        		}else{
	        			eventTypeList = eventTypeList+','+value.name;
	        		}
	        		var eventString = value.event_date+'_'+value.event_id+'_'+value.place
	        		if('' == eventList){
	        			eventList = eventString;
	        		}else{
	        			eventList = eventList+','+eventString;
	        		}
	        		
	        		var row = addPersonRow(value.event_date,value.name,value.place,eventString);
	        		$("#editPepoleModal #eventRows").append(row);
	        	});
	        	
	        	$("#editPepoleModal #eventRowsValues").val(eventList);
	        	$("#editPepoleModal #eventRowsData").val(eventTypeList);
	        },
	        error: function(data) {      
	        		var obj = jQuery.parseJSON(data.responseText);	   
		        	 if (obj.genName) {
			        	$("#editPepoleModal #genName-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-genName').html(obj.genName);
		        	 }
		        	 if (obj.personRelation) {
			        	$("#editPepoleModal #personRelation-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-personRelation').html(obj.personRelation);
		        	 }
		        	 if (obj.personFamily) {
			        	$("#editPepoleModal #personFamily-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-personFamily').html(obj.personFamily);
		        	 }
		        	 if (obj.eventRowsValues) {
			        	$("#editPepoleModal #personEvents-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-personEvents').html(obj.eventRowsValues);
			        }
	        }
	    });
	});
	
	function removeVal(string,to_remove)
	{
			var elements=string.split(",");
			var remove_index=elements.indexOf(to_remove);
			elements.splice(remove_index,1);
			var result=elements.join(",");
			return result;	  
	}
	
	var editPepoleForm = $("#frmEditPepole");
	editPepoleForm.submit(function(e) {
		e.preventDefault();		
		var formData = editPepoleForm.serialize();
		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/gedcom/pepole/update',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	$("#editPepoleModal").modal('hide');
	        	location.reload(); 
	        },
	        error: function(data) {      
	        		var obj = jQuery.parseJSON(data.responseText);	   
		        	 if (obj.genName) {
			        	$("#editPepoleModal #genName-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-genName').html(obj.genName);
		        	 }
		        	 if (obj.personRelation) {
			        	$("#editPepoleModal #personRelation-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-personRelation').html(obj.personRelation);
		        	 }
		        	 if (obj.personFamily) {
			        	$("#editPepoleModal #personFamily-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-personFamily').html(obj.personFamily);
		        	 }
		        	 if (obj.eventRowsValues) {
			        	$("#editPepoleModal #personEvents-div").addClass("has-error");
		            	$('#editPepoleModal #form-errors-personEvents').html(obj.eventRowsValues);
		        	 }
	        }
	    });
		});
	
	$(document).on("click", ".deleteMember", function() {
		var mid = $(this).attr("mid");	
				
		BootstrapDialog.confirm({
	        title: 'CONFIRM',
	        message: 'Are you sure you want to delete this member?',
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
	        			url: '/gedcom/pepole/delete',
	        			type: 'POST',
	        			data: {memId: mid},
	        			success: function(data) {	        				
	        				location.reload(); 
	        			},
	        			error: function(data) {            	
	        				location.reload(); 
	        			}
	        		});
	            } else {
	                return false;
	            }
	        }
	    });
		
	});
});
