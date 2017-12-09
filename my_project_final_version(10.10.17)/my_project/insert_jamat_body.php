<body>

<div class="container" id="div_signup" style="margin-top: -50px;margin-left: 35px;">

  <div >
    
<?php

  if(isset($_POST['insert_main_jamat_time'])){
    //$user = new User();
    //$main_msg = $user->insert_main_jamat_time_data();
    //echo $main_msg;
    require 'ck_insert_main_table.php';
  }

?>

  </div>

  <div class="container" style="height: 160px;margin-left: -30px;color: black;font-family: Arial;">
    <div class=" col-sm-6" style="margin-top: 15px;">
      <h1 ><i style="border-bottom: 1px solid white;">INSERT JAMAT TIME OF TOMORROW <?php echo "(".date("Y-m-d", strtotime(' +1 day')).")" ?> :</i></h1>
    </div>
<!-- ADMIN PANEL -->
  
  <?php
    $mail = Session::get('email');
    if(isset($mail)){
      if($mail == "mehadi541@gmail.com" || $mail == "taanmoycse15@gmail.com" || $mail == "rezaul44@gmail.com"){

  ?>

    <div class="col-sm-6" style="height:120px;background-color: black;opacity: .4;">
      <div style="text-align: center;color: red;"><h3><strong style="border-radius:2px;padding: 5px ;border: 2px dotted white;">Admin Panel:</strong></h3>
      </div>
      <div>
        <form class="form-horizontal pull-right" action="" method="POST">
          <button style="color: #000000;" name="insert_main_jamat_time" type="submit" class="btn btn-info">Inset data in main table</button>
        </form>
      </div>
    </div>

    <?php 
      } 
    }
    ?>
  </div>

  <?php
      if(isset($msg)){
        echo $msg;
      }
  ?>    

<?php

  include 'insert_jamat_body_time.php';

?>
  <form name="insert_jamat" class="form-horizontal" action="" method="POST">

    <div class="form-group" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
      <label class="col-xs-1 control-label">Country:</label>
      <div class="col-xs-3 selectContainer" style="margin-left: 70px;">
          <select class="form-control" name='country' id="insert_jamat_time_country">
          <?php
              $sql = "SELECT DISTINCT COUNTRY FROM district";
              $query = $user->db->pdo->prepare($sql);
              $query->execute();
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

    <div class="form-group" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
      <label class="col-xs-1 control-label">City:</label>
      <div class="col-xs-3 selectContainer" style="margin-left: 70px;">
          <select class="form-control" name="district" id="insert_jamat_time_city">
              <option value=''>CHOOSE A CITY--</option>
          </select>
      </div>
    </div>

    <div class="form-group" style="margin:5px 0px 10px -10px;font-family:Courier;font-size:20px;">
      <label class="col-xs-2 control-label">Masjid Name:</label>
      <div class="col-xs-3 selectContainer" style="margin-left: -15px;">
          <select class="form-control" name="masjid" id="insert_jamat_time_masjid">
              <option value=''>CHOOSE A MASJID NAME--</option>
          </select>
      </div>
    </div>


<div class="container" style="margin-left: -30px;font-family:Courier;font-size:20px;">

    <div class="form-group">
      <label class="control-label col-sm-2" for="username" style="color: #000000;">FAJR:</label>
        <div class="col-xs-3 selectContainer">
          <select class="form-control" name="fajr_hour1">
              <?php echo $fajr_hour1; ?>
          </select>

        </div>

       <div class="col-xs-3 selectContainer">      
          <select class="form-control" name="fajr_minute1">
              <?php echo $fajr_minute1; ?>
          </select>
        </div>

        <div class="col-xs-3 selectContainer" style="color: red;">
          <h4>AM</h4>
        </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2"  style="color: #000000;">DUHUR:</label>
      <div class="col-xs-3 selectContainer">
        <select class="form-control" name="duhur_hour1">
            <?php echo $duhur_hour1; ?>
        </select>

      </div>
      <div class="col-xs-3 selectContainer">      
          <select class="form-control" name="duhur_minute1">
              <?php echo $duhur_minute1; ?>
          </select>

      </div>
          
      <div class="col-xs-3 selectContainer" style="color: red;">
          <h4>PM</h4>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" style="color: #000000;;">ASR:</label>
       <div class="col-xs-3 selectContainer">
          <select class="form-control" name="asr_hour1">
              <?php echo $asr_hour1; ?>
          </select>
        </div>

      <div class="col-xs-3 selectContainer">      
          <select class="form-control" name="asr_minute1">
              <?php echo $asr_minute1; ?>
          </select>
      </div>
          
      <div class="col-xs-3 selectContainer" style="color: red;">
          <h4>PM</h4>
      </div>

    </div>

 <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: #FF8C00;">MAGRIB:</label>
      <div class="col-xs-3 selectContainer">
            <select class="form-control" name="magrib_hour1">
                <?php echo $magrib_hour1; ?>
            </select>

      </div>

      <div class="col-xs-3 selectContainer">      
            <select class="form-control" name="magrib_minute1">
                <?php echo $magrib_minute1; ?>
            </select>

      </div>
            
      <div class="col-xs-3 selectContainer" style="color: red;">
            <h4>PM</h4>
      </div>
    </div>

  <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: #FF8C00;">ISHA:</label>
      <div class="col-xs-3 selectContainer">
            <select class="form-control" name="isha_hour1">
                <?php echo $isha_hour1; ?>
            </select>
      </div>

       <div class="col-xs-3 selectContainer">      
            <select class="form-control" name="isha_minute1">
                <?php echo $isha_minute1; ?>
            </select>
      </div>
            
      <div class="col-xs-3 selectContainer" style="color: red;">
            <h4>PM</h4>
      </div>
  </div>
   
    <div class="form-group pull-right">        
      <div class="col-sm-offset-2 col-sm-10">
        <button name="insert_jamat_time" type="submit" class="btn btn-lg btn-success">Send</button>
      </div>
    </div>
</div>

  </form>
</div>
</body>