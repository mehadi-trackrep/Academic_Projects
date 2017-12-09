<?php

	include_once 'Session.php';
	include 'Database.php';

	class User{
		public $db;
		public function User(){
			$this->db = new Database();
		}

		public function get_task_user_id($task_id){
			$sql = "SELECT USER_ID FROM tasks WHERE task_id = '$task_id'";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result->USER_ID;
		}

		public function getgrantedjobs(){
			$user_id = Session::get('user_id');
			$sql = "SELECT * FROM tasks WHERE task_id IN (SELECT task_id FROM approved_jobs WHERE bidder_id = '$user_id')";

			$dbLink = mysqli_connect("localhost", "root", "");
			//mysql_query("SET character_set_results=utf8", $dbLink);
			mysqli_select_db($dbLink,"task_share");
			 
			$getquery = mysqli_query($dbLink,$sql);

			$str = "";

			$i = 1;

			while($rows = mysqli_fetch_assoc($getquery))
			{
				
				if (isset($rows['task_name'])) {
						$task_name = $rows['task_name'];
				}
				if (isset($rows['USER_ID'])) {
						$employer_id = $rows['USER_ID'];
				}
				if (isset($rows['delivery_address'])) {
						$address = $rows['delivery_address'];
				}
				if (isset($rows['budget'])) {
						$budget = $rows['budget'];
				}
				if (isset($rows['currency_unit'])) {
						$unit = $rows['currency_unit'];
				}

				$sql = "SELECT * FROM user WHERE USER_ID = '$employer_id'";
				$query = $this->db->pdo->prepare($sql);
				$query->execute();
				$result = $query->fetch(PDO::FETCH_OBJ);
				$user_name = $result->USER_NAME;

				$str .= "<div class='col-sm-1' style='font-size: 25px;'>Task no: <strong>{$i}</strong></div>";

				$str .= "<div class='col-sm-11' style='background-color: #0A9768;margin-bottom: 20px;'>
						 <div class='col-sm-8' >
						 <table style='margin-bottom: 5px;margin-top:10px;padding-bottom: 2px solid white;style='color: black;>"."<tr style='color: white;'><td><label size='40px' style='background-color: white;color: green;font-weight: 25px;' type='text' name='name'>Task name: {$task_name}</td></tr>";
				$str .= "<tr style='color: white;'><td colspan='5'><textarea disabled style='color: black;' name='comment' rows='5' cols='50'>Address: {$address}</textarea></td></tr>";
				$str .= "<tr style='color: white;'><td colspan='5'>Budget: {$budget} {$unit}</td></tr>";

				$str .= "</table><hr size='1'></div>";

				$str .= "<div class='col-sm-4'>
						 <center>
						 <h4 style='color: yellow;'>Approved by <strong style='color: white;'>{$user_name}</strong></h4>
						 </center>
						 </div>";
				
				$str .= "</div>";
				$i++;
			}

			//$str .= "</div>";
			return $str;

		}

		public function updateapproved($task_id,$bidder_id){
			try{
				$sql = "INSERT INTO approved_jobs(task_id,approved,bidder_id) VALUES('$task_id',1,'$bidder_id')";
				$query = $this->db->pdo->prepare($sql);
				$query->execute();
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-success'><h3><strong>Success!! </strong>The task has been approved!</h3></div></div></div>";
				return $msg;
				//return $msg."--".$task_id."--".$bidder_id;
			}catch(Exception $e){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3>Already approved! </h3></div></div></div>";
				return $msg;
				//header("Location: Bidder_details.php");
			}
		}

		public function getallbidderdetails($task_id){
			$dbLink = mysqli_connect("localhost", "root", "");
			//mysql_query("SET character_set_results=utf8", $dbLink);
			mysqli_select_db($dbLink,"task_share");
			 
			$getquery = mysqli_query($dbLink,"SELECT * FROM user WHERE USER_ID IN(SELECT user_id FROM want_to_work WHERE task_id = '$task_id')");

			$str = "<div class='container' style='margin-top:-20px;'><h3 style='color:black;'>All bidder's information:</h3>";

			while($rows=mysqli_fetch_assoc($getquery))
			{
				if (isset($rows['USER_ID'])) {
						$bidder_id = $rows['USER_ID'];
				}
				if (isset($rows['USER_NAME'])) {
						$name = $rows['USER_NAME'];
				}
				if (isset($rows['EMAIL'])) {
						$email = $rows['EMAIL'];
				}
				if (isset($rows['NID_NUMBER'])) {
						$nid_no = $rows['NID_NUMBER'];
				}
				if (isset($rows['DISTRICT'])) {
						$city = $rows['DISTRICT'];
				}

				$Mixed = array($task_id, $bidder_id);
				$Text = json_encode($Mixed);
				$RequestText = urlencode($Text);
				
				$str .= "<div class='container' style='margin-bottom: 20px;'>";
					
				$str .=	"<div class='container' style='margin-left: 20px;background-color: #33A2FF  ;'>
						<div class='col-sm-8'>
						<h4>Name:  <strong>{$name}</strong></h4>
				        <h4>Email:  <strong>{$email}</strong></h4>
				        <h4>NID number:  <strong>{$nid_no}</strong></h4>
				        <h4>City:  <strong>{$city}</strong></h4></div>";

				$str .= "<div class='col-sm-4 pull-right' style='margin-top: 40px;'>
						<center>
						<a href='approvedjobs.php?mixed_ara={$RequestText}' class='btn btn-info btn-lg' style='background-color:green;'>Approve</a>
						</center></div></div>";
				
				$str .= "</div>";
			}

			$str .= "</div>";
			return $str;
		}

		public function my_jobs($user_id){

			$dbLink = mysqli_connect("localhost", "root", "");
			
			//mysql_query("SET character_set_results=utf8", $dbLink);
			mysqli_select_db($dbLink,"task_share");
			 
			$getquery = mysqli_query($dbLink,"SELECT * FROM tasks WHERE USER_ID = '$user_id' ORDER BY task_id DESC");

			$str = "<div class='container-fluid' style='margin-top:-20px;'><h1 style='color:black;'>Sorted Jobs:</h1>";

			//$str = "";

			$i = 1;

			while($rows=mysqli_fetch_assoc($getquery))
			{
				if (isset($rows['task_id'])) {
						$id = $rows['task_id'];
				}
				if (isset($rows['task_name'])) {
						$name = $rows['task_name'];
				}
				if (isset($rows['describe_task'])) {
						$describe_task = $rows['describe_task'];
				}
				if (isset($rows['task_deadline'])) {
						$deadline = $rows['task_deadline'];
				}
				if (isset($rows['delivery_address'])) {
						$address = $rows['delivery_address'];
				}
				if (isset($rows['budget'])) {
						$budget = $rows['budget'];
				}
				if (isset($rows['currency_unit'])) {
						$unit = $rows['currency_unit'];
				}
				//$str .= "task_id=> ".$id;
				
				$str .= "<div class='col-sm-1' style='font-size: 25px;'>Task no: <strong>{$i}</strong></div>";

				$str .= "<div class='col-sm-11' style='background-color: #BE4545;margin-bottom: 20px;'>
						<div class='col-sm-8' >
						<table style='margin-bottom: 5px;margin-top:10px;padding-bottom: 2px solid white;'>
						<tr style='color: white;'>
						<td><label size='40px' style='background-color: white;color: green;font-weight: 25px;' type='text' name='name'>{$name}</td></tr>";

				$str .= "<tr style='color: white;'><td colspan='5'><textarea disabled style='color: black;' name='comment' rows='5' cols='50'>{$describe_task}</textarea></td></tr>";
				$str .= "<tr style='color: white;'><td colspan='5'>Delivery address --> {$address}</td></tr>";
				$str .= "</table></div>";

				$str .= "<div class='col-sm-4'>
				        <table style='margin-bottom: 5px;margin-top:10px;padding-bottom: 2px solid white;color: black;'>
				        <tr><td><label size='40px' style='color: white;font-weight: 25px;' type='text' name='name'>Deadline: {$deadline}</td></tr>";
				$str .= "<tr style='color: black;background-color: yellow;'><td colspan='5'>Payment: {$budget} {$unit}</td></tr>";
				$str .= "<tr style='color: black;'><td colspan='5'><a href='Bidder_details.php?task_id={$id}' class='btn btn-success' style='background-color: blue;'>See Bidders</a></td></tr>";
				$str .= "</table><hr size='1'></div>";
				
				$str .= "</div>";

				$i++;
			}

			$str .= "</div>";
			return $str;

		}

		public function wantwork($user_id,$task_id){
			try {
			    $sql = "INSERT INTO want_to_work(user_id,task_id) VALUES('$user_id','$task_id')";
				$query = $this->db->pdo->prepare($sql);
				$result = $query->execute();
				if($result){
					$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, Request have been sent!!</h3></div></div></div>";
					return $msg;
				}else{
					$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have a problem</h3></div></div></div>";
					return $msg;
				}
			} catch (Exception $e) {
			    $msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3>You have already requested for this job</h3></div></div></div>";
				return $msg;
			}
				
		}

		public function getalldetails($data){
			$job_id = $data;

		  	$sql = "SELECT * FROM user WHERE USER_ID = (SELECT USER_ID FROM tasks WHERE task_id = :job_id)";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':job_id',$job_id);
			$query->execute();
			$result = $query->fetch(PDO:: FETCH_OBJ);

			$name = $result->USER_NAME;
			$email = $result->EMAIL;
			$nid_no = $result->NID_NUMBER;
			$district = $result->DISTRICT;

			$sql = "SELECT * FROM tasks WHERE task_id = '$job_id'";
			$query = $this->db->pdo->prepare($sql);
			$result = $query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);

			$clat = 24.918027;
			$clon =  91.831192;

			$task_name = $result->task_name;
			$skill_name = $result->skill_name;
			$describe_task = $result->describe_task;
			$address = $result->delivery_address;
			$currency_unit = $result->currency_unit;
			$budget = $result->budget;
			$task_deadline = $result->task_deadline;

			$sql = "SELECT LATTITUDE,LONGITUDE FROM location WHERE DIS_ID = 1 AND REGION LIKE '$address'";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetch(PDO:: FETCH_OBJ);

			$dlat = $result->LATTITUDE;
			$dlon = $result->LONGITUDE;

			$distance = $this->distance($clat, $clon, $dlat, $dlon, "K"). " Kilometers"; // ==========================================

			$msg = "<h1>Service Provider's Profile:</h1><hr size='1'>
					<div class='container-fluid' style='margin-left: 20px;'>
					<h4>Name:  <strong>{$name}</strong></h4>
			        <h4>Email:  <strong>{$email}</strong></h4>
			        <h4>NID number:  <strong>{$nid_no}</strong></h4>
			        <h4>City:  <strong>{$district}</strong></h4></div><br><br>";

			$msg .= "<h1>Task Details:</h1><hr size='1'>
					<div class='container-fluid' style='margin-left: 20px;'>
					<h4>Task name:  <strong>{$task_name}</strong></h4>
			        <h4>Skill name:  <strong>{$skill_name}</strong></h4>
			        <h4>Task description:  <strong>{$describe_task}</strong></h4>
			        <h4>Delivery address:  <strong>{$address}</strong></h4>
			        <h4>Budget:  <strong>{$budget} {$currency_unit}</strong></h4>
			        <h4>Task deadline:  <strong>{$task_deadline}</strong></h4>
			        <h2>Distance from current location:  <strong>{$distance}</strong></h2></div>";

			return $msg;

		}

		public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);

		  if ($unit == "K") {
		    return ($miles * 1.609344);
		  } else if ($unit == "N") {
		      return ($miles * 0.8684);
		    } else {
		        return $miles;
		      }
		}

		public function all_jobs(){

			$user_id = Session::get('user_id');

			$sql = "SELECT * FROM tasks WHERE USER_ID != '$user_id'";
			$query = $this->db->pdo->prepare($sql);
			$result = $query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			
			$dbLink = mysqli_connect("localhost", "root", "");
			//mysqli_query("SET character_set_results=utf8", $dbLink);
			mysqli_select_db($dbLink,"task_share");
			mb_language('uni');
			mb_internal_encoding('UTF-8');
			 
			$getquery = mysqli_query($dbLink,"SELECT * FROM tasks WHERE USER_ID != '$user_id' ORDER BY task_id DESC");

			if($result){
				$details = "";
				$str = $result->describe_task;
				$len = strlen($str);
				for( $i = 0; ($i <= $len); $i++ ) {
				    $char = substr( $str, $i, 1 );
				    $details .= $char;
				}

				$str = "<div class='container-fluid' style='margin-top:-20px;'><h1 style='color:black;'>Sorted Jobs:</h1>";

				$i = 1;

				while($rows=mysqli_fetch_assoc($getquery))
				{
					/*$details = "";
					if (isset($rows['describe_task'])) {
						$str = $rows['describe_task'];
						$len = strlen($str);
						for( $i = 0; ($i <= $len && $i <= 100); $i++ ) {
						    $char = substr( $str, $i, 1 );
						    $details .= $char;
						}
					}*/
					if (isset($rows['task_id'])) {
							$id = $rows['task_id'];
					}
					if (isset($rows['task_name'])) {
							$name = $rows['task_name'];
					}
					if (isset($rows['describe_task'])) {
							$comment = $rows['describe_task'];
					}
					if (isset($rows['task_deadline'])) {
							$deadline = $rows['task_deadline'];
					}
					if (isset($rows['delivery_address'])) {
							$address = $rows['delivery_address'];
					}
					if (isset($rows['budget'])) {
							$budget = $rows['budget'];
					}
					if (isset($rows['currency_unit'])) {
							$unit = $rows['currency_unit'];
					}
					//$comment = $details;

					$str .= "<div class='col-sm-1' style='font-size: 25px;'>Task no: <strong>{$i}</strong></div>";

					$str .= "<div class='col-sm-11' style='background-color: #19771F;margin-bottom: 20px;'><div class='col-sm-8'><table style='margin-bottom: 5px;margin-top:10px;padding-bottom: 2px solid white;'>"."<tr style='color: white;'><td><label size='40px' style='background-color: white;color: green;font-weight: 25px;' type='text' name='name'>{$name}</td></tr>";
					$str .= "<tr style='color: white;'><td colspan='5'><textarea disabled style='color: black;' name='comment' rows='5' cols='50'>{$comment}</textarea></td></tr>";
					$str .= "<tr style='color: white;'><td colspan='5'>Delivery address --> {$address}</td></tr>";
					$str .= "</table></div>";

					$str .= "<div class='col-sm-4'><table style='margin-bottom: 5px;margin-top:10px;padding-bottom: 2px solid white;'>"."<tr style='color: white;'><td><label size='40px' style='color: white;font-weight: 25px;' type='text' name='name'>Deadline: {$deadline}</td></tr>";
					$str .= "<tr style='color: black;background-color: yellow;'><td colspan='5'>Payment: {$budget} {$unit}</td></tr>";
					$str .= "<tr style='color: black;'><td colspan='5'><a href='details.php?task_id={$id}' class='btn btn-primary'>View Details</a></td></tr>";
					$str .= "</table><hr size='1'></div>";
					
					$str .= "</div>";

					$i++;
				}

				$str .= "</div>";
				return $str;

			}else{
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there are no data</h3></div></div></div>";
				return $msg;
			}
		}

		public function store_task_info($data){
			$task_name = $data['task_name'];
			$skill_name = $data['skill_name'];
			$describe_task = $data['describe_task'];
			$delivery_address = $data['delivery_address'];
			$currency_unit = $data['currency_unit'];
			$budget = $data['budget'];
			$task_deadline = $data['task_deadline'];

			if($task_name == "" OR $skill_name == "" OR $describe_task == "" OR $delivery_address == "" OR $currency_unit == "" OR $budget == "" OR $task_deadline == ""){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			$user_id = Session::get('user_id');

			$sql = "INSERT INTO tasks(task_name, USER_ID, skill_name, describe_task, delivery_address, currency_unit, budget, task_deadline) VALUES('$task_name','$user_id','$skill_name','$describe_task','$delivery_address','$currency_unit','$budget','$task_deadline')";

			$query = $this->db->pdo->prepare($sql);
			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, Task have been posted!!</h3></div></div></div>";
				return $msg;
				//header("Location: index.php");
			}else{
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your tasks</h3></div></div></div>";
				return $msg;
			}

		}

		public function employer($data){
			//$employer_id
			$lat = $data['lattitude'];
			$lon = $data['longitude'];

			if($lat == "" OR $lon == ""){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			$sql = "INSERT INTO employer(LATTITUDE,LONGITUDE) VALUES(:lat, :lon)"; // sql er khettere variable er poriborte ':'(colon) user korlei kaj hoy jay :)
			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':lat',$lat);
			$query->bindValue(':lon',$lon);
			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, it has been done!!</h3></div></div></div>";
				//return $msg;
				//header("Location: location2.php");
			}else{
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
				return $msg;
			}
		}

		public function registration_validation($data){
			$username 	= $data['username'];
			$email 		= $data['email'];
			$nid_no 		= $data['NID_number'];
			$district 		    = $data['district'];
			$password 	= $data['password'];
			$cpassword 	= $data['cpassword'];

			$ck_email = $this->emailCheck($email);

			if($username == "" OR $email == "" OR $nid_no == "" OR $district == "" OR $password == "" OR $cpassword == ""){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			if(strlen($username) < 5){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Username is too short</h3></div></div></div>";
				return $msg;
			}
			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}
			if($ck_email == true){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>The email already exists</h3></div></div></div>";
				return $msg;
			}
			if($password != $cpassword){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Confirm password did not match!</h3></div></div></div>";
				return $msg;
			}

			$sql = "INSERT INTO user(USER_NAME,EMAIL,NID_NUMBER,DISTRICT,PASSWORD) VALUES(:username, :email, :nid_no, :district, :password)"; // sql er khettere variable er poriborte ':'(colon) user korlei kaj hoy jay :)
			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':nid_no',$nid_no);
			$query->bindValue(':district',$district);
			$query->bindValue(':password',$password);
			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, you have been registered!!</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
				return $msg;
			}
		}

		public function getLoginUser($email,$password){
			$sql = "SELECT * FROM user WHERE EMAIL = :email";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			$query->execute();
			$result = $query->fetch(PDO:: FETCH_OBJ);	// object akare $result tare rakhlam ...
			return $result;
		}

		public function emailCheck($email){

			$sql = "SELECT EMAIL FROM user WHERE email = :email";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			$query->execute();

			if($query->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function user_login($data){
			$email 		= $data['email'];
			$password 	= md5($data['password']);

			$ck_email = $this->emailCheck($email);
			/*$ck_password = $this->passwordCheck($email);*/

			if($email == "" OR $password == ""){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must be not empty</h3></div></div></div>";
				return $msg;
			}
			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}
			if($ck_email == false){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>The email does not exist</h3></div></div></div>";
				return $msg;
			}
			$user_all_data = $this->getLoginUser($email,$password); // all datas of the user

			if($user_all_data){
				Session::init();
				Session::set("login",true);
				Session::set("user_id",$user_all_data->USER_ID);
				Session::set("email",$user_all_data->EMAIL);
				Session::set("username",$user_all_data->USER_NAME);
				Session::set("NID_number",$user_all_data->NID_NUMBER);
				Session::set("district",$user_all_data->DISTRICT);
				Session::set("loginmsg","<div class='container alert' style='color: red;font-size: 20px;background-color: lightgray;margin-bottom: 10px;margin-left:80px;max-width: 1000px;'><div class='col-sm-4' style='text-align: center;margin-top: -0.5em'><strong>Success! </strong>You are logged in</div> <div class='col-sm-8' style='text-align: center;size: 5;margin-top: -0.5em'><masquee behavior='scroll' direction='left'><strong>Welcome</strong>!! <font face='verdana' color='purple;'><i>{$user_all_data->USER_NAME}</i></font></div></masquee></div>");
					
					header("Location: index.php");
				
			}else{
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger' style='background-color: lightblue;'><h3><strong>Error! </strong>Data not found</h3></div></div></div>";
				return $msg;
			}

		}

		public function emailCheckinProfile($email,$user_id){
			//echo "user id: ".$user_id;
			$sql = "SELECT EMAIL FROM user WHERE USER_ID = :user_id";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':user_id',$user_id);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
//			echo "email: ".$result->EMAIL;
			if($result->EMAIL == $email){
				return false;
			}else{
				$sql = "SELECT email FROM user WHERE EMAIL = :email";
				$query = $this->db->pdo->prepare($sql);
				$query->bindValue(':email',$email);
				$query->execute();
				if($query->rowCount() > 0){
					return true;
				}else{
					return false;
				}
			}
		}

		public function updateUserData($user_id,$data){
			$username 	= $data['username'];
			$email 		= $data['email'];
			$nid_no 		= $data['NID_number'];
			$district 		    = $data['district'];
			$password 	= $data['password'];
			$cpassword 	= $data['cpassword'];

			$ck_email = $this->emailCheckinProfile($email,$user_id);

			if($username == "" OR $email == "" OR $nid_no == "" OR $district == "" OR $password == "" OR $cpassword == ""){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			if(strlen($username) < 5){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Username is too short</h3></div></div></div>";
				return $msg;
			}

			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}

			if($ck_email == true){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>The email already exists</h3></div></div></div>";
				return $msg;
			}

			if($password != $cpassword){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Confirm password did not match!</h3></div></div></div>";
				return $msg;
			}

			$sql = "UPDATE user SET 
						USER_NAME = :username,
						EMAIL = :email,
						NID_NUMBER = :nid_no,
						DISTRICT = :district,
						PASSWORD = :password WHERE USER_ID = :user_id ";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':nid_no',$nid_no);
			$query->bindValue(':district',$district);
			$query->bindValue(':password',$password);
			$query->bindValue(':user_id',$user_id);

			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-success'><h3><strong>Success! </strong>Userdata Updated Successfully.</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Userdata Not Updated!.</h3></div></div></div>";
				return $msg;
			}

		}

		public function  getUserById($user_id){
			$sql = "SELECT * FROM user WHERE USER_ID = :user_id";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':user_id',$user_id);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

	}

?>