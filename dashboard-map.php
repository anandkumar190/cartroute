m<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Map View</title>
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
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css"/>
  <link rel="stylesheet" href="bower_components/datatable-button.css"/>
<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body>
   <div class="container">
    <div class="row">
      <div class="col-md-3">
         <div class="form-group">
           <label>Select State</label>
           <select class="form-control select2" id="state">
             <option value="">Select State</option>
             
           </select>
         </div>
      </div>
      <div class="col-md-3">
         <div class="form-group">
           <label>Select Region</label>
           <select class="form-control select2" id="region">
             <option value="">Select Region</option>
             
           </select>
         </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
           <label>Select Area</label>
           <select class="form-control select2" id="area">
             <option value="">Select Area</option>
             
           </select>
         </div>
      </div>
       
       <div class="col-md-3">
        <div class="form-group">
           <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><br/>
           <button type="button" class="" id="search"><i class="fa fa-search"></i> Search</button>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <img src="images/spinner.gif" alt="progess image" id="loader" width="50px" height="50px" style="display:none;"/>
         </div>
      </div>
       
    </div>
  </div>    
    <div id="map"></div>
    
<script src="bower_components/jquery/dist/jquery.min.js"></script> 
    
    <script>
      var map;
	  var marker;
	  var latlng = new google.maps.LatLng(20.5937, 78.9629);
      marker.setPosition(latlng);
	  function initMap() {
		  $("#loader").show();
        //var myLatLng = {lat:28.96368627576849, lng: 77.73731481415368};
		var state=$("#state option:selected").text();
		var region=$("#region option:selected").text();
		var area=$("#area option:selected").text();
		$.ajax({
			 url:'api/outlets-web.php?showmap&state='+state+'&region='+region+'&area='+area,
			 type:"GET",
			 contentType:"application/json; charset=utf-8",
			 success: function(data){
			 //alert(data);
			 $("#loader").hide();
			 data=JSON.parse(data);
			 var latLng=[];
			 var Titles=[];
			 for(var i=0;i<data.length;i++)
			 {
			    var lat=parseFloat(data[i].latitude);
			    var lng=parseFloat(data[i].longitude);
				var title=""+(data[i].name+" - "+data[i].address);
			   
				var myLatLng = {lat:lat, lng:lng};
				latLng[i]=myLatLng;
				Titles[i]=title;
				 //if(state!="Select State" && state!="Select Region" && state!="Select Area")
			     //alert(title+" Lat="+lat+"  Lng "+lng );
			 }
			 
		     map = new google.maps.Map(document.getElementById('map'),        {
          zoom: 5,
          center: {lat:20.5937, lng:78.9629},
		  mapTypeId:google.maps.MapTypeId.ROADMAP
        });
		  
		   for(var i=0;i<latLng.length;i++)
		   {
		      var mark = new google.maps.Marker({
               position: latLng[i],
               map: map,
               title: Titles[i],
			   
               });
			  
			  // var infowindow = new google.maps.InfoWindow({
               // content:""+Titles[i]
              // });
			   //mark.addListener('click', function() {
               //infowindow.open(map, mark);
               //});
			   
			  // google.maps.event.addListener(mark,'click',function() {
              // map.setZoom(9);
              // map.setCenter(mark.getPosition());
			     //infowindow.open(map, mark);
              // });
			   
			   // process multiple info windows
                    (function(mark, i) {
                        // add click event
                        google.maps.event.addListener(mark, 'click', function() {
                           var infowindow = new google.maps.InfoWindow({
                                content: Titles[i]
                            });
                            infowindow.open(map, mark);
                        });
                    })(mark, i);
			   
		   }
		   
		    
			 },error: function(error) {alert(error.Message);}
          });
        
      }
	  
	  function ff()
	  {

             $.ajax({
			 url:"api/login.php?get&userid=88",
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
	  //setInterval(ff,200);
	  
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD84GbCm3s_24FlRO1GwuG-vxGsJObga3U&callback=initMap">
    </script>
    <script>
    function state()
	  {
             //alert("Hello");
             $.ajax({
			 url:"api/outlets-web.php?getstate",
			 type:"GET",			 
			 contentType:"application/json; charset=utf-8",
			 success: function(data){
			 data=JSON.parse(data);
			   var state=$("#state");
			   state.empty();
			   var option=$("<option value='' >").html("Select State");
			   state.append(option);
			   $.each(data, function (i, user) {
                        //Create new option
                        option = $('<option value='+user.state+'>').html(user.name);
                        //append city states drop down
                        state.append(option);
                    });
			 }});
	  }
	  
	  function region(state)
	  {
            
             $.ajax({
			 url:"api/outlets-web.php?getregion&state="+state,
			 type:"GET",			 			 
			 contentType:"application/json; charset=utf-8",
			 success: function(data){
			 //alert(data);
			 data=JSON.parse(data);
			   
			   var state=$("#region");
			   state.empty();
			   var option=$("<option value='' />").html("Select Region");
			   state.append(option);
			   $.each(data, function (i, user) {
                        //Create new option
                        option = $('<option value='+user.region+' />').html(user.name);
                        //append city states drop down
                        state.append(option);
                    });
			 }});
	  }
	  
	  function area(state,region)
	  {

             $.ajax({
			 url:"api/outlets-web.php?getcity&region="+region+"&state="+state,
			 type:"GET",			 
			 contentType:"application/json; charset=utf-8",
			 success: function(data){
				 //alert(data);
			 data=JSON.parse(data);
			   
			   var state=$("#area");
			   state.empty();
			   var option=$("<option value='' />").html("Select Area");
			   state.append(option);
			   $.each(data, function (i, user) {
                        //Create new option
                           option = $('<option value='+user.id+'>').html(user.area);
                        //append city states drop down
                        state.append(option);
                    });
			 }});
	  }
	  
	  state();
	  $("#state").change(function(){
		   var state=$("#state option:selected").val();
		   region(state);
		  });
		  
		  $("#region").change(function(){
		   var state=$("#state option:selected").val();
		   var region=$("#region option:selected").val();
		   area(state,region);
		  });
		  
		  $("#search").click(function(){			  
			  initMap();
			  });
    </script>
     
  </body>
</html>