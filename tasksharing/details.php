<?php
  include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkSession();
	
  $task_id = $_GET['task_id'];

  $res = $user->getalldetails($task_id);

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['want_work'])){
		$user_id = Session::get('user_id');
    $ck_task_user_id = $user->get_task_user_id($task_id);
    if($user_id != $ck_task_user_id){
		  $msg = $user->wantwork($user_id,$task_id);
    }else{
      $msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>You can not bid your own task</h3></div></div></div>";
    }
  }

?>

<div class="contianer-fluid" style="color: black;">
  <div class="contianer pull-right">
    <a href="contract_task.php" class='btn btn-primary btn-lg'>Previous page</a>
  </div>
  <div class="contianer">
  	<?php  if(isset($msg)) {echo $msg;} ?>

  		<?php if(isset($res)){ echo $res;?>
  	<form class="form-horizontal" action="" method="POST">
  		<button class="btn btn-success btn-lg pull-right" type="submit" name="want_work" style="margin-right: 25%;">Want to work</button>
  	</form>
  		<?php } ?>
  </div>
</div>