<?php
  include_once 'Session.php';
  Session::init();
?>
<html lang="en">
<head>

  <title>Salat and Jamat Time Finder</title> <!-- Jamat time Taking -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <!--   <link href="index.css" rel="stylesheet"> 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
  <script type="text/javascript" src="js/index.js" ></script>
  <script type="text/javascript" src="js/jamat_time.js" ></script>
  <script type="text/javascript" src="js/insert_jamat_time.js"></script>

  <style type="text/css">
    body{
      /*background-image: url('images/back_img11.jpg');*/
      /*background-image: url('images/back_img6.jpg');*/
      background-color: #6D9AC7;
      /*background-repeat: no-repeat;*/
    }
    #nav_ul1 li a:hover{
        background-color: green;
        color: #ea7915;
    }

    #nav_ul2 li a:hover{
        background-color: green;
        color: #ea7915;
    }
    .navbar-inverse .navbar-toggle:focus, .navbar-inverse .navbar-toggle:hover {
        background-color: #dc0e0e;
    }
    .navbar-inverse .navbar-toggle {
        border-color: #fd4343;
    }
    .button{
      color: white;
      background-color: red;
    }
  </style>

</head>

<?php
  if(isset($_GET['action']) && $_GET['action'] == "logout"){
    Session::destroy();
  }
?>

<body onload="geoloc()">

<div class="container-fluid" style="margin-top:150px; opacity: .9;" >
  <nav class="navbar navbar-fixed-top" role="navigation" style=" background-color: black;">
    <div class="container-fluid" id="div1">
      <div class="navbar-header">

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <!-- <a href="#" class="navbar-left"><img src="/path/to/image.png"></a> -->

        <a class="navbar-brand" style="margin-top: 2px;"><img src="images/logo1.png" width="40px" height="40px" class ="img-responsive" style="margin-top:-15px">
        </a>
        <a href="index.php" class="navbar-brand" style="margin-top: 2px;"><font color="GoldenRod" face="verdana" size="3"><strong><i class="fa fa-home" aria-hidden="true">
        Jamat Time Find System</i></strong></font></a>
        
      </div>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav" id="nav_ul1">

          <li style="padding-left: 3px solid red;"><a href="Jamat_Time.php" class="btn btn-md" style="color: white;"><span aria-hidden="true"></span> Jamat Time</a></li>
          <li style="padding-left: 3px solid red;"><a href="#" class="btn btn-md" style="color: white;"><span aria-hidden="true"></span> Features</a></li>
          <li style="padding-left: 3px solid red;"><a href="#" class="btn btn-md" style="color: white;"><span aria-hidden="true"></span> About Us</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right" id="nav_ul2"> <!-- id="ul2" !-->

          <?php
            $ck_user_login = Session::get("login");
            if($ck_user_login == true){
          ?>
            
              <li><a href="profile.php" class="btn btn-md" style="color: white;"><span class="fa fa-user-circle" aria-hidden="true"></span> Profile</a></li>
              <li><a href="?action=logout" class="btn btn-md" style="color: white;"><span class="fa fa-sign-out" aria-hidden="true"></span> Logout</a></li>

          <?php }else{ ?>
          <!--
          !-->
          <li><a href="signup.php" class="btn btn-md" style="color: white;"><span class="fa fa-user-plus" aria-hidden="true"></span> Sign Up</a></li>
          <li><a href="login.php" class="btn btn-md" style="color: white;"><span class="fa fa-sign-in" aria-hidden="true"></span> Login</a></li>

          <?php } ?>
          
        </ul>

      </div>
    </div>
  </nav>

  <div>
    <?php
      include 'index_slider.php';
    ?>

  <!--
       <button class="pull-right" style="margin-top: -300px;">
          <a href="#homepage_salat" class="btn btn-lg btn-primary" style="background-color: black;padding: 40px 40px 40px 40px;color: purple;font-size: 25px;"><strong>See Salat Time</strong></a>
        </span>
  -->
    <?php
      $val1 = Session::get("login");
      $val2 = Session::get("loginmsg");

      if($val2){
        echo $val2;
        Session::set("loginmsg","");
      }else{
        echo $val2;
      }
    ?>
    
  </div>
