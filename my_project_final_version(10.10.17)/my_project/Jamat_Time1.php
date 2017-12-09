<?php
  include 'User.php';
  //Session::set('profile',false);
  include 'header.php';
  //Session::checkSession();
  
  $user = new User();
?>


<?php
  
    // FOR MONTH ..........................
    $val = array("January","February","March","April","May","June","July","August","September","October","November","December");
    $ind = 0;
    $month = "<option value=''>CHOOSE A MONTH--</option>";
    while($ind < 12){
      $month .= "<option value='$val[$ind]' style='color: #0d47a1;'>$val[$ind]</option>";
      $ind++;
    }

    //FOR DAY................................
    $value=1;
    $day = "<option value=''>CHOOSE A DAY--</option>";
    while($value<=31){
      $day .= "<option value='$value' style='color: #0d47a1;'>$value</option>";
      $value++;
    }

?>

<!-- Body !-->

<?php
  if(isset($_POST['get_salat_time'])){
    if(!empty($_POST['country']) AND !empty($_POST['district']) AND !empty($_POST['month']) AND !empty($_POST['day'])) {
      
      $c = $_POST['country'];
      $d = $_POST['district'];
      $m = $_POST['month'];
      $da = $_POST['day'];

      $ii = 0;
      while ($m != $val[$ii]) {
        $ii++;
      }

      $m = ++$ii;

      $sql = 'SELECT DIS_ID FROM district WHERE COUNTRY = :c AND DISTRICT = :d';

      $res = $user->db->pdo->prepare($sql);

      $res->bindParam(':c', $c, PDO::PARAM_STR);
      $res->bindParam(':d', $d, PDO::PARAM_STR);

      $res->execute();
      $val = $res->fetch(PDO::FETCH_ASSOC);

      $salat_result = "";

      if($val){

        $sql2 = "SELECT * FROM salat_time WHERE DIS_ID = {$val['DIS_ID']} AND MONTH = $m AND DAY = $da"; // SQL A PROBLEM ACE MAY BE...

        $salat_result = $user->db->pdo->prepare($sql2);
        $salat_result->execute();

      }
    
      // FOR COMBO BOX
      
      $show_salat = $salat_result->fetch(PDO::FETCH_ASSOC);
      if(!$show_salat){
          echo "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h4><strong>Error! </strong>Data have not found!!</h4></div></div></div>\n"; 
      }
    }
    else {
     echo "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h4><strong>Error! </strong>Field must not be empty</h4></div></div></div>\n";
   }
  }
?>



<div class="container">

<?php
   include 'combo_box.php';
?>

  <div class="container" style="opacity: .8;">
  
    <table class="table table-inverse" style="width:100%; background-color: black;">

        <tr style="color: white;">
            <th class="col-sm-3">DAY</th> <!-- background-color: violet; !-->
            <td class="col-sm-3"><?php 
                  if(isset($salat_result)){
                      echo $show_salat['DAY']-20;
                  }
                ?>
            </td>
        </tr>
        <tr style="color: white;">
            <th>FAJR</th>
            <td><?php 
                  if(isset($salat_result)){
                      echo "05:45AM";//$show_salat['FAJR'];
                  }
                ?>
            </td>
        </tr>
        <tr style="color: white;">
            <th >DHUHR</th>
            <td><?php 
                  if(isset($salat_result)){
                      echo "01:30PM";//$show_salat['DHUHR'];
                  }
                ?>
            </td>
        </tr>
        <tr style="color: white;">
            <th >ASR</th>
            <td><?php 
                  if(isset($salat_result)){
                      echo "05:45PM";//$show_salat['ASR'];
                  }
                ?>
            </td>
        </tr>
        <tr style="color: white;">
            <th >MAGRIB</th>
            <td><?php 
                  if(isset($salat_result)){
                      echo "07:15PM";//$show_salat['MAGRIB'];
                  }
                ?>
            </td>
        </tr>
        <tr style="color: white;">
            <th >ISHA</th>
            <td><?php 
                  if(isset($salat_result)){
                      echo "08:45PM";//$show_salat['ISHA'];
                  }
                ?>
            </td>
        </tr>

    </table>

    </div>

</div>




<div class="container" id="div_signup">

  <div class="panel-heading">
    <h1 style="color: violet;">Edit Jamat Time:</h1>
  </div>  
  <!-- <h2>Horizontal form</h2> -->
  <form name="signup" class="form-horizontal" action="" method="POST">

    <div class="container">
        <label class="col-xs-1 control-label" style="background-color: yellow;margin-top:5px;">Country:</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="country" style="color: #0d47a1;">
                <?php echo $country; ?>
            </select>
        </div>
      </div>

      <div class="container" style="margin-top: 20px;">
        <label class="col-xs-1 control-label" style="background-color: yellow;margin-top:5px;">City:</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="district" style="color: #0d47a1;">
                <?php echo $district; ?>
            </select>
        </div>
      </div>

      <div class="container" style="margin-top: 20px;">
        <label class="col-xs-1 control-label" style="background-color: yellow;margin-top:5px;">Month:</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="month" style="color: #0d47a1;">
                <?php echo $month; ?>
            </select>
        </div>
      </div>

      <div class="container" style="margin-top: 20px;">
        <label class="col-xs-1 control-label" style="background-color: yellow;margin-top:5px;">Day:</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="day" style="color: #0d47a1;">
                <?php echo $day; ?>
            </select>
        </div>
      </div>


      <div class="container" style="margin-top: 30px;">
      <label class="control-label col-sm-2" for="name" style="color: yellow;">FAJR:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="masjid_name" placeholder="Enter Fajr Jamat Time">
      </div>
    </div>


      <div class="container" style="margin-top: 20px;">
      <label class="control-label col-sm-2" for="name" style="color: yellow;">DHUHR:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="masjid_name" placeholder="Enter Dhuhr Jamat Time">
      </div>
    </div>


      <div class="container" style="margin-top: 20px;">
      <label class="control-label col-sm-2" for="name" style="color: yellow;">ASR:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="masjid_name" placeholder="Enter Asr Jamat Time">
      </div>
    </div>


      <div class="container" style="margin-top: 20px;">
      <label class="control-label col-sm-2" for="name" style="color: yellow;">MAGRIB:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="masjid_name" placeholder="Enter Magrib Jamat Time">
      </div>
    </div>


      <div class="container" style="margin-top: 20px;">
      <label class="control-label col-sm-2" for="name" style="color: yellow;">ISHA:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="masjid_name" placeholder="Enter Isha Jamat Time">
      </div>
    </div>

      <div class="form-group" style="margin-top:15px; margin-left: 400px;">
        <input type="submit" class="btn btn-info" name="get_salat_time" value="Edit Jamat Time" style="background-color: purple;">
      </div>

   
  </form>
</div>



<?php
  include 'footer.php';
?>

</body>
</html>
