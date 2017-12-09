<?php
    include 'User.php';
?>

<html>

<head>

      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>
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
    <h1 style="color:black;">User <strong>Profile</strong>
      <?php
        if(Session::get("login") == true){
          echo "<font face='verdana' color='purple'>"."<i>"."(".Session::get("username")."):"."</i>"."</font>";
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
      <label class="control-label col-sm-2" for="username" style="color: red;">Username:</label>
      <div class="col-sm-6">
        <input style="background-color: lightgray;color:blue;" type="text" class="form-control" name="username" value="<?php echo $userdata->USER_NAME; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="email" style="color: red;">Email:</label>
      <div class="col-sm-6">
        <input style="background-color: lightgray;color:blue;" type="email" class="form-control" name="email" value="<?php echo $userdata->EMAIL; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="name" style="color: red;">NID number:</label>
      <div class="col-sm-6">
        <input  style="background-color: lightgray;color:blue;"type="text" class="form-control" name="NID_number" value="<?php echo $userdata->NID_NUMBER; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="name" style="color: red;">City:</label>
      <div class="col-sm-6">
        <input style="background-color: lightgray;color:blue;" type="text" class="form-control" name="district" value="<?php echo $userdata->DISTRICT; ?>">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: red;">Password:</label>
      <div class="col-sm-6">          
        <input style="background-color: lightgray;color:blue;" type="password" class="form-control" name="password" value="<?php echo $userdata->PASSWORD; ?>" data-toggle="password">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: red;">Confirm Password:</label>
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