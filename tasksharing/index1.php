
<?php
  include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkSession();
?>


<?php
  
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
    $msg = $user->employer($_POST);

    $sql = "SELECT COUNT(*) AS cnt FROM employer";
    $res = $user->db->pdo->prepare($sql);
    $res->execute();
    $last_id = $res->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM employer WHERE EMPLOYER_ID = {$last_id['cnt']}";
    $res = $user->db->pdo->prepare($sql);
    $res->execute();
    $lat_lon = $res->fetch(PDO::FETCH_ASSOC);

    $lat = $lat_lon['LATTITUDE'];
    $lon = $lat_lon['LONGITUDE'];

    $a = $lat;
    $b = $lon;

    //echo $lat." ".$lon."=== ".$a." ".$b;
     
  }

?>

<?php

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_current_location'])){

    $sql = "SELECT COUNT(EMPLOYER_ID) AS cnt FROM employer";
    $res = $user->db->pdo->prepare($sql);
    $res->execute();
    $last_id = $res->fetch(PDO::FETCH_ASSOC);

    //echo $last_id['cnt'];

    $ind = $last_id['cnt']; // just last insert id

    $sql = "SELECT * FROM employer WHERE EMPLOYER_ID = {$ind}";
    $res = $user->db->pdo->prepare($sql);
    $res->execute();
    $lat_lon = $res->fetch(PDO::FETCH_ASSOC);

    $lat = $lat_lon['LATTITUDE'];
    $lon = $lat_lon['LONGITUDE'];

    // delete
    /*
    $ind = $last_id['cnt'] + 3;
    $sql = "DELETE FROM employer WHERE EMPLOYER_ID = {$ind}";
    $res = $user->db->pdo->prepare($sql);
    $res->execute();
    */

    $a = $lat;
    $b = $lon;
    
    echo $a." --- ".$b;
  }

?>

<div class="container-fluid" style="margin-bottom: 20px;">

  <?php
    $val1 = Session::get("login");
    $val2 = Session::get("loginmsg");

    if($val2){
      echo $val2;
      Session::set("loginmsg","");
    }else{
      echo $val2;
    }
  ?>

  <h1><i><strong>Get a task done</strong></i></h1>
</div>
    <?php
      if(isset($msg)){
        echo $msg;
      }
  ?>


<div class="container-fluid">

  <form class="form-horizontal" action="" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="text" style="color: black;">Delivery address:</label>
      <div class="col-sm-6">          
        <textarea style="width:590px;text-decoration: center;" placeholder="Enter Delivery address"></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" style="color: black;">Lattitude:</label>
      <div class="col-sm-6">          
        <input type="text" style="background-color: lightgray;color:blue;" class="form-control" name="lattitude" placeholder="Enter Lattitude">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" style="color: black;">Longitude:</label>
      <div class="col-sm-6">          
        <input type="text" style="background-color: lightgray;color:blue;" class="form-control" name="longitude" placeholder="Enter Longitude">
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-success">Submit</button>
      </div>
    </div>

<!--
    <div class="form-group">
      <label class="control-label col-sm-2" style="color: black;text-decoration: underline;">Otherwise:</label>        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label style="color:black;"><input type="checkbox" onclick='handleClick(this);'>Use current location address</label>
        </div>
      </div>
    </div>
    -->

  </form>

<!--
  <form class="form-horizontal" action="" method="POST" style="margin-top: 50px;">
      <div class="col-sm-12">          
        <button onclick="getLocation()" style="color: #000000;" name="submit_current_location" type="submit" class="btn btn-success btn-lg">Submit Current Location as Delivery Address</button>
      </div>

  </form>
  -->

</div>

<div class="container-fluid">
    <div id='map-canvas'  style="height: 70%;margin-bottom: 50px;margin-top: 20px;">
      <h1>Wait for user current location</h1>
    </div>
</div>

</div>


<div class="container" id ="output">
  
</div>



<!-- ================================================================================= -->

<!--

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
-->

<!-- <script src="js/user_current_location.js"></script> -->

<!--

<script>
 
  /*
  var x = document.getElementById('output');
  var watchId = null;
  */
window.alert("check1");

function geoloc() {
  
  //window.alert("check");

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

-->

<?php
  
  //include 'TANMOY.php';

?>



<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApenMGDYhdpEBZ_bWRSeNCSoo1n5Ic-Xg&callback=myMap"></script>

<script>
  

  function initialize() {

      var lat = 24.81;//<?php echo $a ?>;
      var lon = 91.356;//<?php echo $b ?>;

      window.alert(lat + "      "+lon);

      var mapOptions = {
          zoom: 10,
          center: new google.maps.LatLng(lat,lon)
      };
      var map = new google.maps.Map(document.getElementById('map-canvas'),
              mapOptions);

      var location = new google.maps.LatLng(lat,lon);
      var position = new google.maps.LatLng(location.lat(), location.lng());

      var marker = new google.maps.Marker({
          position: position,
          map: map
      });
      marker.setTitle((1).toString());
      attachSecretMessage(marker);
  }

  function attachSecretMessage(marker) {
      
      var message = 'Tanmoy_Mehadi';
      var infowindow = new google.maps.InfoWindow({
          content: message
      });
      google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(marker.get('map'), marker);
      });
  }
  
  window.alert(lat+" -ck- "+lan); //----------------------------------------------

  google.maps.event.addDomListener(window, 'load', initialize);

</script>



<!--
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

    window.alert(lat1+" === "+lon1); //===========================

    $.ajax({
      url: 'use_current_location.php',
      data: {'lat1':lat1,'lon1':lon1},
      type: 'POST',
      success: function(data){
        ;
      }
    });

  }


</script>

-->

<!-- <script src="give_value_for_location.js"></script>
<script src="using_current_location.js"></script> -->

<?php
  include 'footer.php';
?>

</body>
</html>
