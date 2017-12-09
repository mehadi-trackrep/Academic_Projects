<?php
  include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkSession();
	
  $task_id = $_GET['task_id'];

  $res = $user->getallbidderdetails($task_id);


?>

<div class="contianer-fluid" style="color: black;">
  <div class="contianer pull-right">
    <a href="myprojects.php" class='btn btn-primary btn-lg'>Previous page</a>
  </div>
    
    <?php if(isset($res)){ echo $res; } ?>

</div>
