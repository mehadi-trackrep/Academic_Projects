<?php
	$con_db = mysqli_connect("localhost", "root", "", "user");

	$name = $_POST['user_name'];
	$password = $_POST['pass'];
	
	if($name =="" || $password == ""){
		echo "form field all not are completed :(";
	}
	else{
		$sql = "INSERT INTO user_sign_in VALUES('".$name."', '".$password."')";
		$query = mysqli_query($con_db,$sql);

		if(!$query){
		echo "Faild".mysqli_error();
		}else{
			echo "sucessful";
		}
	}
?>