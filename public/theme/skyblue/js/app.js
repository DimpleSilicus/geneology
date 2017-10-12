
$(document).ready(function () {

    $('iframe#upload_target').load(function () {
        var bn = $('iframe#upload_target').contents().find('#filesMessage').html();
        $('#iframeText').html(bn);
    });
    
    var loginForm = $("#loginForm");
    loginForm.submit(function(e) {
		$(".login-link").addClass("open");
		e.preventDefault();
		
		var formData = loginForm.serialize();
		
		$('#form-errors-username').html("");
		$("#form-errors-password").html("");
		$("#username-div").removeClass("has-error");
		$("#password-div").removeClass("has-error");
              
        $.ajax({
            url: '/login',
            type: 'POST',
            data: formData,
            success: function(data) {            
            	$(".login-link").removeClass("open");
            	//window.location.href = "/login";
            	window.location = '/';
            	//location.reload();
               
            },
            error: function(data) {            	
            	$(".login-link").addClass("open");
                console.log(data.responseText);
                var obj = jQuery.parseJSON(data.responseText);
                if (obj.username) {
                	$("#username-div").addClass("has-error");
                	$('#form-errors-username').html(obj.username);
                }
                if (obj.password) {
                    $("#password-div").addClass("has-error");
                    $("#form-errors-password").html(obj.password);
                }
                if (obj.error) {
                   // $("#login-errors").addClass("has-error");
                   // $('#form-login-errors').html(obj.error);
                }
            }
        });
    });


    
});


/** 
 *@author      : Dimple Agarwal <dimple.agarwal@silicus.com>
 *@description : function to get gedcom amount 
 */

function GetGedAmount(value)
{
//    alert("GetAmount"+value);
    
    $.ajax({
	     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	     type:'POST',
	     url:'/user/GetAmount',
	     data:{gedcomValue:value},
  		 success: function(data)
  		 {
  			 console.log('user is online:::'+data);
                         $('#GedComAmount').html('Amount: $'+data[0]['amount']);
                         $('#GedComAmt').val(data[0]['amount']);
  		 }
  });
  
}
