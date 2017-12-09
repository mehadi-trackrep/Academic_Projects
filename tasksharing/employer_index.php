
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
    $sql = "SELECT COUNT(*) AS cnt FROM employer";
    $res = $user->db->pdo->prepare($sql);
    $res->execute();
    $last_id = $res->fetch(PDO::FETCH_ASSOC);

    //echo $last_id['cnt'];

    $ind = $last_id['cnt'] + 4; // just last insert id

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
    
    //echo $a." --- ".$b;
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

  <form class="form-horizontal" action="" method="POST" style="margin-top: 50px;">
      <div class="col-sm-12">          
        <button onclick="getLocation()" style="color: #000000;" name="submit_current_location" type="submit" class="btn btn-success btn-lg">Submit Current Location as Delivery Address</button>
      </div>

  </form>

</div>

<div class="container-fluid">
    <div id="map-canvas" style="height: 70%;margin-bottom: 50px;margin-top: 20px;"></div>
</div>

<script>
  
  /*
  function handleClick(cb){
    alert("dsfsd");
    clocation();
  }
  */

  function initialize() {
      var lat = <?php echo $a ?>;
      var lon = <?php echo $b ?>;

      var mapOptions = {
          zoom: 10,
          center: new google.maps.LatLng(lat,lon)
      };
      var map = new google.maps.Map(document.getElementById('map-canvas'),
              mapOptions);

      // Add 1 marker to the map at one location
      // bms developer group
      var location = new google.maps.LatLng(lat,lon);
      var position = new google.maps.LatLng(location.lat(), location.lng());

      var marker = new google.maps.Marker({
          position: position,
          map: map
      });
      marker.setTitle((1).toString());
      attachSecretMessage(marker);
  }
  // The five markers show a secret message when clicked
  // but that message is not within the marker's instance data
  function attachSecretMessage(marker) {
      //var message = 'BMS Developer Group';
      var message = 'Tanmoy_Mehadi';
      var infowindow = new google.maps.InfoWindow({
          content: message
      });
      google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(marker.get('map'), marker);
      });
  }
  google.maps.event.addDomListener(window, 'load', initialize);
</script>

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

    //window.alert(lat1+" "+lon1);

    $.ajax({
      url: 'use_current_location.php',
      data: {'lat1':lat1,'lon1':lon1},
      type: 'POST',
      success: function(data){
        //console.log(data);
        //$('#check').html(data);
      }
    });
  }


</script>

<!-- <script src="give_value_for_location.js"></script>
<script src="using_current_location.js"></script> -->

<?php
  include 'footer.php';
?>

</body>
</html>
