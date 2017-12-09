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

<div class="container" id="div_signup">

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
      <label class="control-label col-sm-2" for="username" style="color: black;">Username:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="username" placeholder="Enter username">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: black;">Email:</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" name="email" placeholder="Enter email">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="name" style="color: black;">NID number:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="NID_number" placeholder="Enter NID number">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="name" style="color: black;">City:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="district" placeholder="Enter city">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: black;">Password:</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" name="password" placeholder="Enter password">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: black;">Confirm Password:</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" name="cpassword" placeholder="Enter confirm password">
      </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label style="color: black;"><input type="checkbox"> Remember me</label>
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
