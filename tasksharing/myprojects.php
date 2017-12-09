<?php
  include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkSession();
?>

<?php

$sorted_by = "<option value='Newest first'>Newest first</option>
			  <option value='Lowest budget first'>Lowest budget first</option>
			  <option value='Highest budget first'>Highest budget first</option>";

    $user_id = Session::get('user_id');
	$post_jobs = $user->my_jobs($user_id);

?>



<div class="container-fluid" style="margin-top: -78px; color:white; background-color: #0087e0;height: 85px;">
	<h1>My Services</h1>
</div>

<div class="container-fluid" style="margin-top: 20px;margin-bottom: 20px;">
	<form name="sortname" class="form-horizontal" action="" method="POST">
		<div class="form-group">
			<label class="control-label col-sm-1">Filter by:</label>
			<div class="col-sm-2">
				<input type=hidden name="st" value=0>
		        <select class="form-control" name="job_filter">
		        	<?php echo $sorted_by; ?>
		        </select>
			</div>
		</div>
	</form>
	<!-- PAGINATION START -->
	<div class="col-sm-4 pull-right"> 
		
	</div>
	<!-- PAGINATION END -->
</div>

<?php
	echo $post_jobs;
?>	

</div>