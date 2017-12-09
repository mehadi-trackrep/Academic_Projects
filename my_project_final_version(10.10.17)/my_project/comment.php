<?php
//mysql_connect("mysql host name","mysql user name","mysql password");
	$dbLink = mysqli_connect("localhost", "root", "");
	mysqli_select_db($dbLink,"jamat_time");
	
	if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
//	$name=$_POST["name"];
     if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
}
	//$comment=$_POST['comment'];
	 if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
}
	//$submit=$_POST['submit'];
		mysqli_query($dbLink,"SET character_set_client=utf8");
		mysqli_query($dbLink,"SET character_set_connection=utf8");
	 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($submit))
	{
		if($name && $comment)
		{
			$insert=mysqli_query($dbLink,"INSERT INTO commenttable (name,comment) VALUES ('$name','$comment') ");
			//echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php'>";
			echo "successful";
		}
		else
		{
			echo "<div class='container'><div class='alert alert-danger'><h1>please fill out all fields</h1></div></div>";
		}
	}
?>



<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comment box</title>
</head>
 
 <?php

 	//$user_name = "mehadi";
 	if(Session::get('login') == true){
 		$user_name = Session::get('username');
 	}
 	else{
 		$user_name = "";
 	}

 ?>

<body>
<center>
<div class="container-fluid" style="margin-top: 20px;margin-bottom: 20px;background-color: #34495E">
	<form action="" method="POST">
		<table>
			<tr style="color: white;"><td>Name: <br><input style="color: black;" type="text" name="name" value=' <?php echo $user_name ?>'></td></tr>
			<tr style="color: white;"><td colspan="2">Comment: </td></tr>
			<tr style="color: white;"><td colspan="5"><textarea style="color: black;" name="comment" rows="10" cols="50"></textarea></td></tr>
			<tr style="color: black;"><td colspan="2"><input type="submit" name="submit" value="Comment"></td></tr>
		</table>
	</form>
</div>


<?php

	$dbLink = mysqli_connect("localhost", "root", "");
	mysqli_query($dbLink,"SET character_set_results=utf8");
	mysqli_select_db($dbLink,"jamat_time");
	mb_language('uni');
	mb_internal_encoding('UTF-8');
	 
	$getquery = mysqli_query($dbLink,"SELECT * FROM commenttable ORDER BY comment_id DESC");

//if(isset($getquery)){
	$str = "<div class='container-fluid' style='margin-top:-20px;background-color: #34495E;'><h3 style='color:white;'>Comments:</h3>";

	while($rows=mysqli_fetch_assoc($getquery))
	{
		if (isset($rows['comment_id'])) {
			$id = $rows['comment_id'];
		}
		//$id=$rows['id'];
		if (isset($rows['name'])) {
				$name = $rows['name'];
		}
		//$name=$rows['name'];
		if (isset($rows['comment'])) {
				$comment = $rows['comment'];
		}
		
		$str .= "<table style='margin-bottom: 5px;margin-top:10px;padding-bottom: 2px solid white;'>"."<tr style='color: white;'><td><label size='40px' style='background-color: white;color: green;font-weight: 25px;' type='text' name='name'>{$name}</td></tr>";

		$str .= "<tr style='color: white;'><td colspan='5'><textarea disabled style='color: black;' name='comment' rows='5' cols='50'>{$comment}</textarea></td></tr>";
		$str .= "</table><hr size='1'>";
		
		//echo "NAME: ".$name . '<br/>' . '<br/>' . "COMMENT: ".$comment . '<br/>' . '<br/>' . '<hr size="1"/>';
		
	}

	$str .= "</div>";
	echo $str;

?>
</center>

</body>
</html>