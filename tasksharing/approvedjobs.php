

<?php
  include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkSession();
	
  $Text = urldecode($_REQUEST['mixed_ara']);
  $Mixed = json_decode($Text);

  $task_id = $Mixed['0'];
  $bidder_id = $Mixed['1'];

  $msg = $user->updateapproved($task_id,$bidder_id);
  
  //header("Location: Bidder_details.php?task_id={$task_id}");
?>

<div class="container-fluid">
  <div class="contianer pull-right">
    <a href="Bidder_details.php?task_id=<?php echo $task_id; ?>" class='btn btn-primary btn-lg'>Previous page</a>
  </div>

  <?php
    
    echo $msg;

  ?>
</div>