<?php
  include 'header.php';
  include 'User.php';
  //Session::checkLogin();
?>

<?php

  $user = new User();
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
    $msg = $user->registration_validation($_POST);
  }

?>

<?php
  include 'signup_heading.php';
?>

<body>

<div class="container" id="div_signup" style="margin-top: -30px;">

  <div class="panel-heading">
    <h1 style="color: violet;">User Registration:</h1>
  </div>

  <?php
      if(isset($msg)){
        echo $msg;
      }
  ?>    
  <!-- <h2>Horizontal form</h2> -->
  <form name="signup" class="form-horizontal" action="" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="username" style="color: yellow;">Username:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="username" placeholder="Enter username">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: yellow;">Email:</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" name="email" placeholder="Enter email">
      </div>
    </div>
<!--  START  -->

      <div class="form-group">
        <label class="control-label col-sm-2" style="color:yellow;">Country</label>
        <div class="col-sm-6 selectContainer">
            <input type=hidden name="st" value=0>
            <select class="form-control" name="country" id="jamat_time_country" style="color: #0d47a1;">
                <option value="">CHOOSE A COUNTRY--</option>

  <?php

    $sql = "SELECT DISTINCT COUNTRY FROM district";
    $query = $user->db->pdo->prepare($sql);
    $query->execute();

    if($query){

    while ($sql_res = $query->fetch(PDO::FETCH_ASSOC)) {

  ?>

      <option value="<?php echo $sql_res["COUNTRY"]; ?>" 
          <?php 
              if(isset($_REQUEST["country"])){
                  if ($sql_res["COUNTRY"] == $_REQUEST["country"]) {
                    echo "Selected";
                  } 
              }
          ?> >
          <?php echo $sql_res["COUNTRY"]; ?>
            
    </option>

  <?php

  }
  }

  ?>
            </select>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" style="color:yellow;">City</label>
        <div class="col-sm-6 selectContainer">
            <input type=hidden name="st" value=0>
            <select class="form-control" name="district" id="jamat_time_city" style="color: #0d47a1;">
                <option value="">CHOOSE A CITY--</option>
            </select>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" style="color:yellow;">Masjid Name</label>
        <div class="col-sm-6 selectContainer">
            <input type=hidden name="st" value=0>
            <select class="form-control" name="masjid" id="jamat_time_masjid" style="color: #0d47a1;">
                <option value="">CHOOSE A MASJID--</option>
            </select>
        </div>
      </div>

<!-- END -->


    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: yellow;">Password:</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" name="password" placeholder="Enter password">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: yellow;">Confirm Password:</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" name="cpassword" placeholder="Enter confirm password">
      </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label style="color: yellow;"><input type="checkbox"> Remember me</label>
        </div>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button name="register" type="submit" class="btn btn-success">Register</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
