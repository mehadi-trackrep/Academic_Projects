<?php 

	$dbconnect = mysqli_connect("localhost", "root", "", "jamat_time"); // ekhane variable er name icca moto ...

	if(mysqli_connect_errno()){
		echo "Connecton failed:".mysqli_connect_error();
		exit;
	}

?>

