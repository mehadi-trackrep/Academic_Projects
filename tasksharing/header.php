<?php
  include_once 'Session.php';
  Session::init();
?>
<html lang="en">
<head>

  <title>Task sharing</title> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link href="index.css" rel="stylesheet">
<!--
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->
<!--

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApenMGDYhdpEBZ_bWRSeNCSoo1n5Ic-Xg&callback=myMap"></script>

-->


</head>

<?php
  if(isset($_GET['action']) && $_GET['action'] == "logout"){
    Session::destroy();
  }
?>

<body> <!-- onload="geoloc()" -->

<div class="container-fluid" style="margin-top:150px;" >
  <nav class="navbar navbar-fixed-top" role="navigation" style=" background-color: black; opacity: .9;">
    <div class="container-fluid" id="div1">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <!-- <a href="#" class="navbar-left"><img src="/path/to/image.png"></a> -->

        <a class="navbar-brand" style="margin-top: 2px;"><img src="images/uber-logo.png" width="40px" height="40px" class ="img-responsive" style="margin-top:-8px">
        </a>
        <a href="index.php" class="navbar-brand" style="margin-top: 2px;"><font color="GoldenRod" face="verdana" size="3"><strong><i class="fa fa-home" aria-hidden="true">
        Task sharing</i></strong></font></a>
        
      </div>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav" id="nav_ul1">
          <li><a href="give_task.php" class="btn btn-md"><span  aria-hidden="true"></span> Give a task</a></li>
          <li><a href="contract_task.php" class="btn btn-md"><span  aria-hidden="true"></span> Take a contract</a></li>
          <li><a href="myprojects.php" class="btn btn-md"><span  aria-hidden="true"></span> MyProjects</a></li>
          <li><a href="grantedjobs.php" class="btn btn-md"><span  aria-hidden="true"></span> Granted jobs</a></li>
          <li><a href="#" class="btn btn-md"><span  aria-hidden="true"></span> Features</a></li>
          <li><a href="index1.php" class="btn btn-md"><span  aria-hidden="true"></span> Location</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right" id="nav_ul2"> <!-- id="ul2" !-->

          <?php
            $ck_user_login = Session::get("login");
            if($ck_user_login == true){
          ?>
            
              <li><a href="profile.php" class="btn btn-md"><span class="fa fa-user-circle" aria-hidden="true"></span> Profile</a></li>
              <li><a href="?action=logout" class="btn btn-md"><span class="fa fa-sign-out" aria-hidden="true"></span> Logout</a></li>

          <?php }else{ ?>
          <!--
          !-->
          <li><a href="signup.php" class="btn btn-md"><span class="fa fa-user-plus" aria-hidden="true"></span> Sign Up</a></li>
          <li><a href="login.php" class="btn btn-md"><span class="fa fa-sign-in" aria-hidden="true"></span> Login</a></li>

          <?php } ?>
          
        </ul>

      </div>
    </div>
  </nav>

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
  
