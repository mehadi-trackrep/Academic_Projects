<?php
  include 'header.php';
  include 'User.php';
  //Session::checkSession();
  $user = new User();
?>

<?php
  $val1 = Session::get("login");
  $val2 = Session::get("loginmsg");

  if($val1){
    echo $val2;
    Session::set("loginmsg","");
  }else{
    //echo "there have a problem in sessions working";
    echo $val2;
  }
?>


<?php

  if(isset($_POST['masjid'])){
      //echo "<div class='container' style='margin-top:500px;margin-bottom:200px;'>".$_POST['masjid']."</div>";
    $masj = $_POST['masjid'];
    $sql = "SELECT * FROM masjid WHERE MASJID_NAME = '$masj'"; /// ????
    $query = $user->db->pdo->prepare($sql);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);
    $a = $res['LATITUDE'];
    $b = $res['LONGITUDE'];

    //echo "<div class='container' style='margin-top:500px;margin-bottom:200px;'>".$a." === ".$b."</div>";
  }

?>

<div class="container-fluid" id="div_signup"  style="margin-top: -40px;margin-bottom: 25px;">

    <div class="container" style="color: #FF8C00;">
      <h2><i>SEE JAMAT TIME</i> <span class="pull-right">  <strong>Welcome</strong> <?php 

      if(Session::get("login") == true){
        echo "<font face='verdana' color='green;'>"."<i>".Session::get("username")."</i>"."</font>";
      }else{
        echo "___";
      }

      ?> </span></h2>
    </div>
</div>

<div class="container-fluid">
    <div class="col-sm-4"  style="margin-top: 10px;margin-right: 10px;">
     
      <form action="" method="POST">

        <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
          <label class="col-xs-1 control-label">Country:</label>
          <div class="col-xs-3 selectContainer">
              <select class="form-control" id="jamat_time_country" name="country">
                  <?php 
                        $sql = "SELECT DISTINCT COUNTRY FROM district"; //  WHERE MONTH=1 AND DAY=7
                        $query = $user->db->pdo->prepare($sql);
                        $query->execute();
                        // FOR COMBO BOX
                        if($query){
                          $country = "<option value=''>CHOOSE A COUNTRY--</option>";
                          while($row = $query->fetch(PDO::FETCH_ASSOC)){
                            $country .= "<option value='{$row['COUNTRY']}'>{$row['COUNTRY']}</option>";
                          }
                        }
                        echo $country;
                  ?>
              </select>
          </div>
        </div>

        <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
          <label class="col-xs-1 control-label">City:</label>
          <div class="col-xs-3 selectContainer">
              <select class="form-control" id="jamat_time_city" name="district">
                  <option value=''>CHOOSE A CITY--</option>
              </select>
          </div>
        </div>

        <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
          <label class="col-xs-1 control-label">Masjid:</label>
          <div class="col-xs-3 selectContainer">
              <select class="form-control" id="jamat_time_masjid" name="masjid">
                  <option value=''>CHOOSE A MASJID--</option>
              </select>
          </div>
        </div>

        <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
          <label class="col-xs-1 control-label">Date:</label>
          <div class="col-xs-3 selectContainer">
              <!--<input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/> -->
              <select class="form-control" id="jamat_time_date" name="date">
                  <option value=''>CHOOSE A DATE--</option>
              </select>
          </div>
        </div>

        <div class="form-group pull-right" style="margin-top: 40px;">        
          <div class="col-sm-offset-2 col-sm-10">
            <button name="jamat_time" type="submit" class="btn btn-success">Get location of the masjid</button>
          </div>
        </div>

      </form>
  </div>

    <div class="col-sm-6" id="jamat_time_div_table1" style="opacity: .7; margin-top:-10px;">
    
      <table class="table table-inverse col-sm-8"  style="margin-top: 20px;background-color: black;">
          <tr>
              <th style="background-color: green;color: white;">JAMAT NAME</th>
              <th style="background-color: green;color: white;">START TIME</th>
             
          </tr>
          <tr style="color: white;">
            <th>FAJR</th>
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

<div class="container-fluid" style="margin-top:15px;">
    <span class="pull-right">  <a href="insert_jamat.php" class="btn btn-lg btn-primary" style="background-color: green;font-size: 25px;"><strong>Insert Jamat Time</strong></a>
    </span>
</div>

<div class="container-fluid">
    <div id="map-canvas" style="height: 70%;margin-top: 20px;"></div>
</div>



<script>

  function initialize() {
      var lat = 26.1234;//<?php  $a ?>;
      var lon = 91.39478;//<?php  $b ?>;

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

<!-- <script src="give_value_for_location.js"></script>
<script src="using_current_location.js"></script> -->

<!--?php
  include 'footer.php';
?-->
</body>
</html>