<?php
  //include 'User.php';
//include 'Session.php';
  //Session::set('profile',true);
  include 'header.php';
  Session::checkSession();
?>

<?php
  	include 'update_profile.php';
?>

<?php
  include 'footer.php';
?>
