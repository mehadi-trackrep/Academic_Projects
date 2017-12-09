
<?php
    include 'User.php';
?>


<!DOCTYPE html>
<html>

<head>

        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>
  <style>
    body{
      background-image: url("images/back_img11.jpg");
    }
    #div_login{
      margin-left: 200px;
    }
  </style>

</head>
    <!-- Body Text !-->
<body>

<?php

  $user = new User();

  $user_id = Session::get('user_id');
  //echo "The user id: ".$user_id;

  $userdata = $user->getUserById($user_id);

  if(isset($_POST['update'])){
    $updatemsg = $user->updateUserData($user_id,$_POST);
  }

?>

<div class="container" id="div_update_profile" style="margin-left: 150px;">

  <div class="panel-heading">
    <h1 style="color:white;">User <strong>Profile</strong>
      <?php
        if(Session::get("login") == true){
          //echo "<p style='font-family: Arial, Helvetica, sans-serif;font-style: oblique'>".Session::get("username")."</p>";
          echo "<font face='verdana' color = '#FF8C00;'>"."<i>"."(".Session::get("username")."):"."</i>"."</font>";
        }else{
          echo "";
        }
      ?>
    </h1>
  </div>
   
  <?php
    if(isset($updatemsg)){
      echo $updatemsg;
    }
  ?>

  <!-- <h2>Horizontal form</h2> -->
  <form class="form-horizontal" action="" method="POST">

    <div class="form-group">
      <label class="control-label col-sm-2" for="username" style="color: aqua;">Username:</label>
      <div class="col-sm-6">
        <input style="background-color: lightgray;color:blue;" type="text" class="form-control" name="username" value="<?php echo $userdata->USER_NAME; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: aqua;">Email:</label>
      <div class="col-sm-6">
        <input style="background-color: lightgray;color:blue;" type="email" class="form-control" name="email" value="<?php echo $userdata->EMAIL; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: aqua;">Country:</label>
      <div class="col-sm-6">
        <input style="background-color: lightgray;color:blue;" type="email" class="form-control" name="name" value="<?php echo $userdata->COUNTRY; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="name" style="color: aqua;">District:</label>
      <div class="col-sm-6">
        <input style="background-color: lightgray;color:blue;" type="text" class="form-control" name="district" value="<?php echo $userdata->DISTRICT; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="name" style="color: aqua;">Masjid Name:</label>
      <div class="col-sm-6">
        <input  style="background-color: lightgray;color:blue;"type="text" class="form-control" name="masjid_name" value="<?php echo $userdata->MASJID_NAME; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: aqua;">Password:</label>
      <div class="col-sm-6">          
        <input style="background-color: lightgray;color:blue;" type="password" class="form-control" name="password" value="<?php echo $userdata->PASSWORD; ?>" data-toggle="password">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: aqua;">Confirm Password:</label>
      <div class="col-sm-6">          
        <input style="background-color: lightgray;color:blue;" type="password" class="form-control" name="cpassword" placeholder="Enter confirm password">
      </div>
    </div>

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="update" class="btn btn-primary">Update</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">

  $("#password").password('toggle');

</script>
</body>
</html>