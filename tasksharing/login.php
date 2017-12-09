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


<div class="container" id="div_login" style="margin-top: 40px;">

  <div class="panel-heading" style="margin-top: -15px;">
    <h1 style="color: #FF8C00;">User Login:</h1>
  </div>

  <?php
      if(isset($msg)){
        echo $msg;
      }
  ?>      
  
  <form class="form-horizontal" action="" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: black;">Email Address:</label>
      <div class="col-sm-6">          
        <input style="background-color: lightgray;color:blue;" type="email" class="form-control" name="email" placeholder="Enter email address">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="password" style="color: black;">Password:</label>
      <div class="col-sm-6">          
        <input type="password" style="background-color: lightgray;color:blue;" class="form-control" name="password" placeholder="Enter password">
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label style="color:black;"><input type="checkbox">Remember me</label>
        </div>
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="login" class="btn btn-success">Login</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>