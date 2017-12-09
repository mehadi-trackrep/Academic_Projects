<?php
  include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkSession();
?>

<div class="container-fluid" style="margin-top: -78px;margin-bottom: 20px; color:white; background-color: #0087e0;height: 85px;">
	<h1>All granted Jobs</h1>
</div>

<?php

	$res = $user->getgrantedjobs();
	echo $res;

?>