<?php
  include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkSession();
?>

<?php

$money_unit = "<option value=''>Select currency</option>
			   <option value='TAKA'>TAKA</option>
			   <option value='USD'>USD</option>
			   <option value='EURO'>EURO</option>";

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_task'])){
	    $msg = $user->store_task_info($_POST);
	}

	  $sql = "SELECT REGION FROM location WHERE DIS_ID = 1";
	  $query = $user->db->pdo->prepare($sql);
	  $query->execute();
	  // FOR COMBO BOX
	  if($query){
	    $combo_box_address = "<option value=''>CHOOSE DELIVERY ADDRESS--</option>";
	    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	      $combo_box_address .= "<option value='{$row['REGION']}'>{$row['REGION']}</option>";
	    }
	  }

?>

<div class="container-fluid" style="margin-top: -80px; color:white; background-color: #0087e0;height: 85px;">
	<h1>Task information</h1>
</div>

<div  class="container-fluid" style="background-color: #313f46;color: white;">
<div class="container" >

    <?php
      if(isset($msg)){
        echo $msg;
      }
  ?>

	<form class="form-horizontal" action="" method="POST">

	    <div class="form-group">
	      <h3>Name of your task</h3>
	      <div class="col-sm-8">
	        <input type="text" class="form-control" name="task_name" placeholder="Enter your task name">
	      </div>
	    </div>

	    <div class="form-group">
	      
	      <h3>Skills Required</h3>
	      <div class="col-sm-8">
	        <input type="text" class="form-control" name="skill_name" placeholder="Enter skills name">
	      </div>
	      <br>

	      <h3>Describe your tasks</h3>
	      <div class="col-sm-8">
	      	<textarea style="width:590px;text-decoration: center;color: black;" name="describe_task" rows="8" cols="50"></textarea>
	      </div>
	    </div>

	    <div class="form-group">
	      <h3>Delivery location</h3> <!-- ============================ -->
	      
	      <div class="col-xs-3 selectContainer">
              <input type=hidden name="st" value=0>
              <select class="form-control" name="delivery_address" style="color: #0d47a1;">
                <?php echo $combo_box_address;  ?>
              </select>
          </div>

	      <!--
	      <div class="col-sm-8">
	        <input type="text" class="form-control" name="delivery_address" placeholder="Enter delivery address">
	      </div>
	      -->
	    </div>

	    <div class="form-group">
	      <h3>Budget</h3>
	      <div class="col-sm-2 selectContainer">
            <input type=hidden name="st" value=0>
            <select class="form-control" name="currency_unit" style="color: #0d47a1;">
            <?php echo $money_unit; ?>
            </select>
      	  </div>

	      <div class="col-sm-4">
	        <input type="text" class="form-control" name="budget" placeholder="Enter budget">
	      </div>
	    </div>

	    <div class="form-group">
	      <h3>Task deadline</h3>
	      <div class="col-sm-8">
	      	<input type="datetime-local" name="task_deadline" style="border-radius: 5px; height: 50px;color: black;">
	      </div>
	    </div>

	    <div class="form-group" style="margin-top: 30px;">        
	        <button  type="submit" name="submit_task" class="btn btn-success btn-lg">Post your job</button>
	    </div>

	</form>

</div>
</div>
</div>