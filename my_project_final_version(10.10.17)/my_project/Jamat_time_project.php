<?php
  include 'header.php';
  include 'db_connect.php';
?>

<?php

    $sql = "SELECT DISTRICT FROM district"; //  WHERE MONTH=1 AND DAY=7
    $sql1 = "SELECT DISTINCT COUNTRY FROM district"; //  WHERE MONTH=1 AND DAY=7

    $result = mysqli_query($dbconnect,$sql);
    $result1 = mysqli_query($dbconnect,$sql1);

    // FOR COMBO BOX

    $country = "<option value='choose a country'>CHOOSE A COUNTRY--</option>";

    while($row = mysqli_fetch_assoc($result1)){
      $country .= "<option value='{$row['COUNTRY']}'>{$row['COUNTRY']}</option>";
    }

    $option = "<select name='district'>";
    $district = "<option value='choose one district'>CHOOSE A DISTRICT--</option>";

    while($row = mysqli_fetch_assoc($result)){
      $option .= "<option value='{$row['DISTRICT']}'>{$row['DISTRICT']}</option>";
      $district .= "<option value='{$row['DISTRICT']}'>{$row['DISTRICT']}</option>";
    }

    $option .= "</select>";

    // FOR MONTH ..........................
    $val = 1;
    $month = "<option value='choose a month'>CHOOSE A MONTH--</option>";
    while($val < 13){
      $month .= "<option value='$val'>$val</option>";
      $val++;
    }

?>

<!-- Body !-->

<div class="container">

  <div class="container">
    <!-- <?php echo $option; ?> !-->
    <form action="Jamat_time_project.php" method="POST">

      <div class="form-group">
        <label class="col-xs-1 control-label" style="background-color: yellow;margin-top:5px;">Country:</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="country">
                <?php echo $country; ?>
            </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-xs-1 control-label" style="background-color: yellow;margin-top:5px;">District:</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="district">
                <?php echo $district; ?>
            </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-xs-1 control-label" style="background-color: yellow;margin-top:5px;">Month:</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="month">
                <?php echo $month; ?>
            </select>
        </div>
      </div>

      <div class="form-group pull-right" style="margin-top:15px;">
        <input type="submit" class="btn btn-primary" name="get_salat_time" value="Get Salat time">
      </div>

    </form>

    <?php
      if(isset($_POST['get_salat_time'])){
        if(!empty($_POST['country']) AND !empty($_POST['district']) AND !empty($_POST['month']) ) {
          
          $c = $_POST['country'];
          $d = $_POST['district'];
          $m = $_POST['month'];

          $sql2 = "SELECT DAY, FAJR, SUNRISE, DHUHR, ASR, MAGRIB, ISHA FROM salat_time WHERE DIS_ID = (SELECT DIS_ID FROM district WHERE COUNTRY = :c AND DISTRICT = :d) AND MONTH = :m"; // SQL A PROBLEM ACE MAY BE...

          $salat_result = mysqli_query($dbconnect,$sql2); // ........................

          if(mysqli_num_rows($salat_result) > 0){
            while($row = mysqli_fetch_assoc($salat_result)){
                echo "DAY: ".$row['DAY']."<br>";
            }
          }

          echo "<span><b>".$_POST['country']."</b></span><br/>".
               "<span><b>".$_POST['district']."</b></span><br/>".
               "<span><b>".$_POST['month']."</b></span><br/>";

        }
        else { echo "<span>Please Select the two field.</span><br/>";}
      }
    ?>

    <div class="container">
  
    <table class="table table-striped">

        <thead>

            <tr>
                <th>DAY</th>
                <th>FAJR</th>
                <th>SUNRISE</th>
                <th>DHUHR</th>
                <th>ASR</th>
                <th>MAGRIB</th>
                <th>ISHA</th>
            </tr>

        </thead>

        <tbody>

            <tr class="info">
                <?php
                  if(isset($salat_result)){
                    $s1 = "<td>".$salat_result[1]."</td>";
                    $s2 = "<td>".$salat_result['SUNRISE']."</td>";
                    $s3 = "<td>".$salat_result['DHUHR']."</td>";
                    $s4 = "<td>".$salat_result['ASR']."</td>";
                    $s5 = "<td>".$salat_result['MAGRIB']."</td>";
                    $s6 = "<td>".$salat_result['ISHA']."</td>";

                    echo $s1; echo $s2; echo $s3; echo $s4; echo $s5; echo $s6;
                  }
                ?>
            </tr>

        </tbody>
    </table>

    </div>

  </div>

</div>


<?php
  include 'footer.php';
?>

</body>
</html>
