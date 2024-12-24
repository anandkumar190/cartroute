<?php $id=$_GET['userid'];?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Employee Location</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    
<script src="bower_components/jquery/dist/jquery.min.js"></script>      
    <script>
      var map;
	  var marker;
	  //var latlng = new google.maps.LatLng(-24.397, 140.644);
    //marker.setPosition(latlng);
	  function initMap() {
        //var myLatLng = {lat:28.96368627576849, lng: 77.73731481415368};
		
		$.ajax({
			 url:"api/login.php?get&userid=<?php echo $id;?>",
			 type:"GET",
			 contentType:"application/json; charset=utf-8",
			 success: function(data){
			 //alert(data);
			 data=JSON.parse(data);
			 var lat=parseFloat(data[0].latitude);
			 var lng=parseFloat(data[0].longitude);
			 var locationdate=(data[0].locationdate);
			 var d = Date.parse(locationdate);
			 var tt=new Date(d).toLocaleTimeString();
			 var dd=new Date(d).toDateString();
			 var name=(data[0].name);
			 var myLatLng = {lat:lat, lng:lng};
			     
		     map = new google.maps.Map(document.getElementById('map'),        {
          zoom: 14,
          center: myLatLng,
		  mapTypeId:google.maps.MapTypeId.ROADMAP
        });
		
		    marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: name+' - '+dd+' - '+tt,
		    icon:'map-marker-red.png'
           });
			 
			 },error: function(error) {alert(error.Message);}
  });
      }
	  
	  function ff()
	  {

             $.ajax({
			 url:"api/login.php?get&userid=<?php echo $id;?>",
			 type:"POST",
			 data:{"userid":"88"},
			 contentType:"application/json; charset=utf-8",
			 success: function(data){
			 data=JSON.parse(data);
			 var lat=parseFloat(data[0].latitude);
			 var lng=parseFloat(data[0].longitude);
			 var myLatLng = {lat:lat, lng:lng};
			 var latlng = new google.maps.LatLng(lat,lng);
             marker.setPosition(latlng);    
		  //var marker = new google.maps.Marker({
          //position: myLatLng,
          //map: map,
          //title: 'Hello World!',
		  //icon:'map-marker-red.png'
        //});
			 }});
	  }
	  setInterval(ff,200);
	  
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD84GbCm3s_24FlRO1GwuG-vxGsJObga3U&callback=initMap">
    </script>
  </body>
</html>