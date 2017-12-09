<?php
  include 'index_header.php';
  include 'User.php';
  $user = new User();

?>


  <div class="container-fluid">
    <h2>SHARE YOUR TASKS AND MAKE LIFE EASY</h2>  
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" style="display:block; height: 100%;" >
        <div class="item active">
          <img src="images/slider0.jpg" alt="Los Angeles" style="width:100%;">
        </div>

        <div class="item">
          <img src="images/slider1.jpg" alt="Chicago" style="width:100%;">
        </div>
      
        <div class="item">
          <img src="images/slider2.jpg" alt="New york" style="width:100%;">
        </div>
      </div>

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>

  <div class="container-fluid" style="margin:0px;">
    <h1 style="color: #FFC307;"><i>User location:</i></h1>
    <div id='map-canvas' style="width: 100%;height: 400px;margin-bottom: 20px;"></div>
    <!-- <button onclick="stopWatch()"> Stop </button> -->
  </div>

<!--

    <form class="form-horizontal" action="" method="POST" style="margin-top: 50px;">
        <div class="col-sm-12">          
          <button onclick="getLocation()" style="color: #000000;" name="submit_current_location" type="submit" class="btn btn-success btn-lg">Submit Current Location as Delivery Address</button>
        </div>

    </form>

    <div class="container" id ="output">
      <h1>check lat, lon</h1>
    </div>

  ->

</div>





<!-- ================================================================================= -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDxwoqGPX2HsHxRV4SaRtLN9-NS3j3WOI&callback=myMap"></script>



<!-- <script src="js/user_current_location.js"></script> -->

<!--
      FOR GET DISTANCE OF LAT, LON

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <script>
    function getLocation(){
      //alert(1);
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showPosition);
      }else{
        window.alert("not support");
      }
    }

    function showPosition(position){

      var lat1 = position.coords.latitude;
      var lon1 = position.coords.longitude;

      window.alert(lat1+" == "+lon1);

      $.ajax({
        url: 'use_current_location.php',
        data: {'lat1':lat1,'lon1':lon1},
        type: 'POST',
        success: function(data){
          //console.log(data);
          $('#output').html(data);
        }
      });
    }


  </script>

-->

<!--    start main locaion code      -->

<script>
 
  /*
  var x = document.getElementById('output');
  var watchId = null;
  */

function geoloc() {
  
  //window.alert("check--");

  if (navigator.geolocation) {
    var optn = {
        enableHighAccuracy : true,
        timeout : Infinity,
        maximumAge : 0
    };
    watchId = navigator.geolocation.watchPosition(showPosition, showError, optn);
  } else {
      alert('Geolocation is not supported in your browser');
  }
}

function showPosition(position) {
  
  var googlePos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  
alert(position.coords.latitude+" ---check--- "+position.coords.longitude); // ========================================

  var mapOptions = {
    zoom : 12,
    center : googlePos,
    mapTypeId : google.maps.MapTypeId.ROADMAP
  };

  var mapObj = document.getElementById('map-canvas');
  var googleMap = new google.maps.Map(mapObj, mapOptions);
  var markerOpt = {
    map : googleMap,
    position : googlePos,
    title : 'Hi , I am here',
    animation : google.maps.Animation.DROP
  };

  var googleMarker = new google.maps.Marker(markerOpt);
  var geocoder = new google.maps.Geocoder();

    geocoder.geocode({
      'latLng' : googlePos
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[1]) {
          var popOpts = {
            content : results[1].formatted_address,
            position : googlePos
          };
          var popup = new google.maps.InfoWindow(popOpts);
          google.maps.event.addListener(googleMarker, 'click', function() {
            popup.open(googleMap);
          });
        } else {
          alert('No results found');
        }
      } else {
        alert('Geocoder failed due to: ' + status);
      }
    });
  }

  function stopWatch() {
    if (watchId) {
      navigator.geolocation.clearWatch(watchId);
      watchId = null;

    }
  }

  function showError(error) {
    var err = document.getElementById('mapdiv');
    switch(error.code) {
      case error.PERMISSION_DENIED:
        err.innerHTML = "User denied the request for Geolocation."
        break;
      case error.POSITION_UNAVAILABLE:
        err.innerHTML = "Location information is unavailable."
        break;
      case error.TIMEOUT:
        err.innerHTML = "The request to get user location timed out."
        break;
      case error.UNKNOWN_ERROR:
        err.innerHTML = "An unknown error occurred."
        break;
      }
  }

</script>


</body>
</html>