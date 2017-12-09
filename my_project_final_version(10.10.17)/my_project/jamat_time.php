<?php
  include 'jamat_time_header.php';
  include 'User.php';

  //Session::checkSession();
  $user = new User();

  //........................................FOR NOTIFICATION:


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

    if(Session::get('login') == true){
      $user_country = Session::get('country');
      $user_district = Session::get('district');
      $user_masjid_name = Session::get('masjid_name');

      $sql = "SELECT DIS_ID FROM district WHERE COUNTRY='$user_country' AND DISTRICT='$user_district'"; /// ????
      $query = $user->db->pdo->prepare($sql);
      $user_dis_id =  $query->execute();

      //$res = $query->fetch(PDO::FETCH_ASSOC);
      //echo "=-=--=--=-=-=->: ".$user_dis_id;

    }

  ?>


  <?php

    $location_masjid_msg = "";

    if(isset($_POST['location_masjid'])){
      
      //echo "check---clicked";

      if(isset($_POST['masjid']) && $_POST['masjid'] != ""){
        
        //echo "also check -- masjid ";

        $masj = $_POST['masjid'];

        //echo $masj;

        $sql = "SELECT * FROM masjid WHERE MASJID_NAME = '$masj'"; /// ????
        $query = $user->db->pdo->prepare($sql);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_ASSOC);
        $a = $res['LATITUDE'];
        $b = $res['LONGITUDE'];

        //echo $a." -=-=- ".$b;

        //$jamat_time_msg = $user->get_jamat_time_after_location_click($_POST);

        
        $location_masjid_msg = "";
      }
      else{
          $location_masjid_msg = "<div class='container' style='margin-left: 100px;'><div class='col-sm-8'><div class='alert alert-danger'><h4><strong>Error! </strong>You have to choose a mosque!!</h4></div></div></div>\n";
      }
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

      <?php
          echo $location_masjid_msg;
      ?>

  </div>

  <div class="container-fluid"> <!-- style="margin-top: 10px;margin-right: 10px;" -->
      <div class="col-sm-4"  style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
       
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

          <div class="form-group pull-left" style="margin-top: 40px;">        
            <div class="col-sm-offset-2 col-sm-10">
              <button name="location_masjid" type="submit" class="btn btn-success btn-md" style="background-color: green;font-size: 17px;">Get location of the masjid</button>
            </div>
          </div>

        </form>
    </div>

      <div class="col-sm-6" id="jamat_time_div_table1" style="opacity: .7; margin-top:-10px;">
        <?php

            if(Session::get('login') == true){
              
             // echo "check for login--";

              $country = Session::get('country');
              $district = Session::get('district');
              $masjid_name = Session::get('masjid_name');

              $sql = "SELECT DIS_ID FROM district WHERE DISTRICT='$district' AND COUNTRY='$country'";
              $query = $user->db->pdo->prepare($sql);
              $dis_id = $query->execute();

              $date = date("Y-m-d");

              //echo $dis_id." -- ".$masjid_name." -- ".$date;

              $sql = "SELECT * FROM jamat_time WHERE DIS_ID='$dis_id' AND MASJID_NAME LIKE '$masjid_name' AND DATE ='$date'";
              $query = $user->db->pdo->prepare($sql);
              $query->execute();
              $self_jamat_time = $query->fetch(PDO::FETCH_ASSOC);

              if(isset($self_jamat_time)){
                include 'jamat_time_self_masjid.php';
              }else{
                echo "also check--";
                include 'jamat_time_format_table.php';  
              }
            }else{
                include 'jamat_time_format_table.php';
            }

        ?>
        
      </div>
    
    </div>

  <div class="container-fluid" style="margin-top:15px;">
      <span class="pull-right">  <a href="insert_jamat.php" class="btn btn-lg btn-primary" style="background-color: green;font-size: 25px;"><strong>Insert Jamat Time</strong></a>
      </span>
  </div>

<?php
  
  //$_SESSION['masjid_name'] = Session::get('masjid_name');

  //require  'notification.php';  // ...............................................

?>

  <div class="container-fluid">
      <div id="map-canvas" style="height: 70%;margin-top: 20px;"></div>
  </div>

<!--  END NAVIGATION BAR DIV TAG -->
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvsk8zdYYcqbjjIUBWDbVwnxCBDjJvBrI&callback=myMap"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>

  function initialize() {
      var lat = <?php  echo $a ?>;
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

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

 <script src="give_value_for_location.js"></script>
<script src="using_current_location.js"></script> -->

<!--  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-==-=-=-=-=-==-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=  -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- <script src="js/user_current_location.js"></script> -->

<script>
 
  /*
  var x = document.getElementById('output');
  var watchId = null;
  */

function geoloc() {

  alert("check1");

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

    // for jamat time show ---
    var dis_id = <?php  echo $user_dis_id ?>;
    var masjid = <?php  echo $user_masjid_name ?>;
    
alert(dis_id+" -- "+masjid);

    $.ajax({
        url: 'get_dynamic_jamat_time.php',
        data: {'dis_id':dis_id, 'masjid':masjid},
        type: 'POST',
        success: function (data) {
            $('#jamat_time_table1').html(data);
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