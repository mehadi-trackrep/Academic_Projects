
<?php
  include 'index_header.php';
  include 'User.php';
  $user = new User();
?>


  <div class="container-fluid" id="div_signup"  style="margin-top: -70px;margin-bottom: 25px;">
      <div class="container" style="color: green;">
        <h2><i>SEE SALAT TIME</i> <span class="pull-right"></h2>
      </div>
  </div>

  <div class="container-fluid">
    <div class="col-sm-4"  style="margin-top: 10px;margin-right: 10px;">

  <?php  include 'combo_box.php'; ?>    

    </div>

      <div class="col-sm-6" id="index_div_table1" style="opacity: .7; margin-top:-10px;">
      
        <table class="table table-inverse col-sm-8" id="index_table1" style="margin-top: 20px;background-color: black;">
          <tr>
              <th style="background-color: green;color: white;">SALAT NAME</th>
              <th style="background-color: green;color: white;">START TIME</th>
             
          </tr>
          <tr style="color: white;">
            <th>FAJR</th>
            <td></td>
          </tr>
          <tr style="color: white;">
            <th>SUNRISE</th>
            <td></td>
          </tr>
          <tr style="color: white;">
              <th >DHUHR</th>
              <td></td>
          </tr>
          <tr style="color: white;">
              <th >ASR</th>
              <td></td>
          </tr>
          <tr style="color: white;">
              <th >MAGRIB</th>
              <td></td>
          </tr>
          <tr style="color: white;">
              <th >ISHA</th>
              <td></td>
          </tr>
        </table>

      </div>
    
    </div>

  <div class="container-fluid" style="margin:0px;">
    <h1 style="color: #FFC307;"><i>User's current location:</i></h1>
    <div id='map-canvas' style="width: 100%;height: 400px;margin-bottom: 20px;"></div>
    <!-- <button onclick="stopWatch()"> Stop </button> -->
  </div>

  <div class="container" id ="output">
    
  </div>

<!--  END NAVIGATION BAR DIV TAG -->
</div>

<?php
  include 'comment.php';
?>


<!-- ================================================================================= -->

<!--
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

-->



<!-- <script src="js/user_current_location.js"></script> -->

<script>
 
  /*
  var x = document.getElementById('output');
  var watchId = null;
  */

function geoloc() {

  //alert("check=>geoloc()"); // .....................

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
  
//alert(position.coords.latitude+"check---"+position.coords.longitude);

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

    // for salat time show ---

    var c,d;
    var all = [];
    var country, district,district1,country1,ddd,ccc;
    //alert("check1---");
    
    //alert(position.coords.latitude+" -- "+position.coords.longitude);

    var locAPI = "http://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+
    position.coords.longitude+"&sensor=true";

   // alert("check2---");

    $.get({
      url: locAPI,
      async:false,
      success: function(data){
        console.log(data);
        //x.innerHTML = data.results[0].address_components[4].long_name+", ";
        district = data.results[0].address_components[4].long_name; // 5,7;   4,6
        //x.innerHTML += data.results[0].address_components[6].long_name+", ";
        country = data.results[0].address_components[6].long_name;

        district1 = data.results[0].address_components[5].long_name; // 5,7;   4,6
        country1 = data.results[0].address_components[7].long_name;

        //alert("check3---");

        if(district){
          if(country){
            ddd = district;
            ccc = country;
            all.push(district);
            all.push(country);
          }else{
            ddd = district;
            ccc = country1;
            all.push(district);
            all.push(country1);
          }
        }else{
          if(country){
            ddd = district1;
            ccc = country;
            all.push(district1);
            all.push(country);
          }else{
            ddd = district1;
            ccc = country1;
            all.push(district1);
            all.push(country1);
          }
        }
        
        //all.push(district);
        //all.push(country);

        //alert(ddd+" -ck- "+ccc);
      }

    });
    
    d = all[0];
    c = all[1];
    
    $.ajax({
        url: 'get_dynamic_salat_time.php',
        data: {'c':c, 'd':d},
        type: 'POST',
        success: function (data) {
            $('#index_table1').html(data);
        }
    }).error(function(){
        alert ('An error occured in index_table1 select id');
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

<?php
  include 'footer.php';
?>