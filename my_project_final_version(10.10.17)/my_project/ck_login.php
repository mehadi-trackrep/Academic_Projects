<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body{
      background-image: url("back_img6.jpg");
    }
    </style>
</head>
<body>

<?php
  $nameErr = $passErr = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["user_name"])) {
      $nameErr = "Username is required";
    }
    if (empty($_POST["pass"])) {
      $passErr = "Password is required";
    }
  }
?>


  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$con_db = mysqli_connect("localhost", "root", "", "user");

	$name = $_POST['user_name'];
	$password = $_POST['pass'];
	
	if($name =="" || $password == ""){
		//echo "form field all not are completed :(";
		;
	}else{
		$sql = "INSERT INTO user_sign_in VALUES('".$name."', '".$password."')";
		$query = mysqli_query($con_db,$sql);

		if(!$query){
		echo "Faild".mysqli_error();
		}else{
			echo "sucessful";
		}
	}
}
?>

<div class="container" style="margin-top: 50px;">
  <form class="form-horizontal" action="ck_signin.php" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2" for="username" style="color: pink;">Username:</label>
      <div class="col-sm-10">
        <input type="username" class="form-control" id="username" name="user_name" placeholder="Enter username">
         <span class="error" style="color: red;">* <?php echo $nameErr;?></span>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd" style="color: yellow;">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" id="pwd" name="pass" placeholder="Enter password">
         <span class="error" style="color: red;">* <?php echo $passErr;?></span>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label><input type="checkbox"> Remember me</label>
        </div>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>


</div>

</body>
</html>