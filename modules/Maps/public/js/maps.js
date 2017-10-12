 /** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to display world maps  
 */

 /*function initialize() {
 var mapOptions = {
     center: new google.maps.LatLng(-34.397, 150.644),
     zoom: 2,
     minZoom: 2
     };
     var map = new google.maps.Map(document.getElementById("wordldMap"), mapOptions);
    
     var myLatLng = {lat: 13.2222011, lng: 80.0949883}; 
     var marker = new google.maps.Marker({
         position: myLatLng,
         map: map,
         title: 'Hello World!'
       });
    
   }          
 google.maps.event.addDomListener(window, 'load', initialize); 
 
 
 getLangLat(); */
 
 /** 
 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
 *@description : function to get longitute/lattitude Details 
 */
 
/*function getLangLat()
 {	
 		$.ajax({
 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
 			url:'/maps/getLatsLong',
 			type:'get',
 			data:{},
 			dataType:'json',
 			success: function(data) 
 			{			
 				$.each(data, function(key,value) {
 					var ss = '{lat:'+value.lat+', lng:'+value.lng+'}';
 					$('#lang').append($('#sss').val(ss));	
 					
 					
 				});
 	        }
 		}); 
 } */




