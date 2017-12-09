<?php
  include 'header.php';
  include 'User.php';
  //Session::checkLogin();
?>

<?php

  $user = new User();
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
    $msg = $user->user_login($_POST);
  }

?>

<?php
  include 'login_heading.php';
?>

<body>


<div class="container" id="div_login" style="margin-top: 50px;">

  <div class="panel-heading" style="margin-top: -15px;">
    <h1 style="color: #FF8C00;">User <strong>Login:</strong></h1>
  </div>

  <?php
      if(isset($msg)){
        echo $msg;
      }
  ?>      
  
  <form class="form-horizontal" action="" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: aqua;">Email Address:</label>
      <div class="col-sm-6">          
        <input style="background-color: lightgray;color:blue;" type="email" class="form-control" name="email" placeholder="Enter email address">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="password" style="color: aqua;">Password:</label>
      <div class="col-sm-6">          
        <input type="password" style="background-color: lightgray;color:blue;" class="form-control" name="password" placeholder="Enter password">
        <!--  hence, ami User.php te shob gula validation kore niyeci ..
          <input type="password" class="form-control" name="password" placeholder="Enter  password"> <!-->
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label style="color: aqua;"><input type="checkbox">Remember me</label>
        </div>
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="login" class="btn btn-success btn-lg">Login</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>