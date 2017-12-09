<?php

	include_once 'Session.php';
	include 'Database.php';

	class User{
		public $db;
		public function User(){
			$this->db = new Database();
		}

		public function registration_validation($data){
			$username 	= $data['username'];
			$email 		= $data['email'];
			$masjid_name 		= $data['masjid_name'];
			$district 		    = $data['district'];
			$password 	= md5($data['password']);
			$cpassword 	= md5($data['cpassword']);

			$ck_email = $this->emailCheck($email);

			if($username == "" OR $email == "" OR $masjid_name == "" OR $district == "" OR $password == "" OR $cpassword == ""){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			if(strlen($username) < 5){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Username is too short</h3></div></div></div>";
				return $msg;
			}

			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}

			if($ck_email == true){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>The email already exists</h3></div></div></div>";
				return $msg;
			}

			if($password != $cpassword){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Confirm password did not match!</h3></div></div></div>";
				return $msg;
			}

			$sql = "INSERT INTO user(USER_NAME,EMAIL,MASJID_NAME,DISTRICT,PASSWORD) VALUES(:username, :email, :masjid_name, :district, :password)"; // sql er khettere variable er poriborte ':'(colon) user korlei kaj hoy jay :)
			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':masjid_name',$masjid_name);
			$query->bindValue(':district',$district);
			$query->bindValue(':password',$password);
			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, you have been registered!!</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
				return $msg;
			}

		}

		public function get_salat_time(){

		}

		public function getLoginUser($email,$password){
			//$sql = "SELECT * FROM user WHERE EMAIL = :email AND PASSWORD = :password";
			$sql = "SELECT * FROM user WHERE EMAIL = :email";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			
			// OR,
			//$query->bindParam(':email', $email, PDO::PARAM_STR);
          	//$query->bindParam(':password', $password, PDO::PARAM_STR);

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
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must be not empty</h3></div></div></div>";
				return $msg;
			}
			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}
			if($ck_email == false){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>The email does not exist</h3></div></div></div>";
				return $msg;
			}
			/*if($ck_password != $password){
				echo $ck_password."<br>";
				echo $password."<br>";
				echo $data['password'];

				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>The password does not match !!</h3></div></div></div>";
				return $msg;
			}*/

			$user_all_data = $this->getLoginUser($email,$password); // all datas of the user

			if($user_all_data){
				Session::init();
				Session::set("login",true);
				Session::set("user_id",$user_all_data->USER_ID);
				Session::set("username",$user_all_data->USER_NAME);
				Session::set("masjid_name",$user_all_data->MASJID_NAME);
				Session::set("district",$user_all_data->DISTRICT);
				Session::set("loginmsg","<div class='container alert alert-success' style='margin-top:-10px;'><div class='col-sm-4' style='text-align: center;'><strong>Success! </strong>You are logged in</div> <div class='col-sm-8' style='text-align: center;size: 5;'><masquee behavior='scroll' direction='left'><strong>Welcome</strong>!! ".$user_all_data->USER_NAME."</div></masquee></div>");
				
				header("Location: index.php");
			}else{
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger' style='background-color: lightblue;'><h3><strong>Error! </strong>Data not found</h3></div></div></div>";
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
			$masjid_name 		= $data['masjid_name'];
			$district 		    = $data['district'];
			$password 	= md5($data['password']);
			$cpassword 	= md5($data['cpassword']);

			$ck_email = $this->emailCheckinProfile($email,$user_id);

			if($username == "" OR $email == "" OR $masjid_name == "" OR $district == "" OR $password == "" OR $cpassword == ""){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			if(strlen($username) < 5){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Username is too short</h3></div></div></div>";
				return $msg;
			}

			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}

			if($ck_email == true){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>The email already exists</h3></div></div></div>";
				return $msg;
			}

			if($password != $cpassword){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Confirm password did not match!</h3></div></div></div>";
				return $msg;
			}

			$sql = "UPDATE user SET 
						USER_NAME = :username,
						EMAIL = :email,
						MASJID_NAME = :masjid_name,
						DISTRICT = :district,
						PASSWORD = :password WHERE USER_ID = :user_id ";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':masjid_name',$masjid_name);
			$query->bindValue(':district',$district);
			$query->bindValue(':password',$password);
			$query->bindValue(':user_id',$user_id);

			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-success'><h3><strong>Success! </strong>Userdata Updated Successfully.</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Userdata Not Updated!.</h3></div></div></div>";
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

		public function inserting_jamat_time_validation($data){

			$country  = $data['country'];
			$district = $data['district'];
			$masjid   = $data['masjid'];

			$fajr_hour1 	= $data['fajr_hour1'];
			$fajr_minute1  	= $data['fajr_minute1'];
			$fajr_am1 		= $data['fajr_am1'];

			$fajr_str       = $fajr_hour1.":".$fajr_minute1;

			$duhur_hour1 	= $data['duhur_hour1'];
			$duhur_minute1 	= $data['duhur_minute1'];
			$duhur_am1 		= $data['duhur_am1'];

			$duhur_str      = $duhur_hour1.":".$duhur_minute1;

			$asr_hour1 		= $data['asr_hour1'];
			$asr_minute1 	= $data['asr_minute1'];
			$asr_am1 		= $data['asr_am1'];

			$asr_str        = $asr_hour1.":".$asr_minute1;

			$magrib_hour1 	= $data['magrib_hour1'];
			$magrib_minute1 = $data['magrib_minute1'];
			$magrib_am1 	= $data['magrib_am1'];

			$magrib_str     = $magrib_hour1.":".$magrib_minute1;

			$isha_hour1 	= $data['isha_hour1'];
			$isha_minute1 	= $data['isha_minute1'];
			$isha_am1 		= $data['isha_am1'];

			$isha_str       = $isha_hour1.":".$isha_minute1;

			if($country == "" OR $district == ""  OR $masjid == "" OR $fajr_hour1 == "" OR $fajr_minute1 == "" OR $fajr_am1 == "" OR $duhur_hour1 == "" OR $duhur_minute1 == "" OR $duhur_am1 == "" OR $asr_hour1 == "" OR $asr_minute1 == "" OR $asr_am1 == "" OR $magrib_hour1 == "" OR $magrib_minute1 == "" OR $magrib_am1 == "" OR $isha_hour1 == "" OR $isha_minute1 == "" OR $isha_am1 == ""){

				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			$sql = "SELECT DIS_ID FROM DISTRICT WHERE DISTRICT = '$district' AND COUNTRY = '$country'";
			$query = $this->db->pdo->prepare($sql);
			$dis_id = $query->execute();

			$masjid_sql = "SELECT MASJID_ID FROM MASJID WHERE DIS_ID = '$dis_id' ";
			$masjid_query = $this->db->pdo->prepare($masjid_sql);
			$masjid_id = $masjid_query->execute();
			$date = date("Y-m-d", strtotime("+1 days"));
			

			$sql = "INSERT INTO temp_jamat_time(MASJID_ID,DATE,MASJID_NAME,FAJR,DUHUR,ASR,MAGRIB,ISHA) VALUES(:masjid_id, :date, :masjid, :fajr_str, :duhur_str, :asr_str, :magrib_str, :isha_str)";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':masjid_id',$masjid_id);
			$query->bindValue(':date',$date);
			$query->bindValue(':masjid',$masjid);
			$query->bindValue(':fajr_str',$fajr_str);
			$query->bindValue(':duhur_str',$duhur_str);
			$query->bindValue(':asr_str',$asr_str);
			$query->bindValue(':magrib_str',$magrib_str);
			$query->bindValue(':isha_str',$isha_str);

			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, Data have Inserted Successfully!!</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
				return $msg;
			}

		}
		

		public function insert_main_jamat_time_data(){
			$date = date("Y-m-d", strtotime("+1 days"));
		
			$masjid_id_sql="SELECT MASJID_ID FROM `masjid`";

            $masjid_query = $this->db->pdo->prepare($masjid_id_sql);
			$masjid_query->execute();

			
			while($masjid_result =$masjid_query->fetch(PDO::FETCH_ASSOC))
			{
			$mas= $masjid_result['MASJID_ID'];
		    
		

		/*	insert into jamat_time( MASJID_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE  DATE = '2017-08-19' AND MASJID_ID=1 AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY FAJR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-08-19' AND MASJID_ID=1 AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY FAJR) )


			UPDATE jamat_time SET DUHUR= (SELECT DUHUR FROM temp_jamat_time WHERE DATE = '2017-08-19' AND MASJID_ID=1 AND DUHUR >= (SELECT DUHUR FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY DUHUR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-08-19' AND MASJID_ID=1  AND DUHUR >=(SELECT DUHUR FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY DUHUR) ))WHERE DATE = '2017-08-19' AND MASJID_ID=1 


			UPDATE jamat_time SET ASR= (SELECT ASR FROM temp_jamat_time WHERE  DATE = '2017-08-19' AND MASJID_ID=1 AND ASR >= (SELECT ASR FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY ASR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE = '2017-08-19' AND MASJID_ID=1  AND ASR >=(SELECT ASR FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY ASR) ))WHERE  DATE = '2017-08-19' AND MASJID_ID=1 

			UPDATE jamat_time SET MAGRIB= (SELECT MAGRIB FROM temp_jamat_time WHERE DATE = '2017-08-19' AND MASJID_ID=1  AND MAGRIB >= (SELECT MAGRIB FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY MAGRIB having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE = '2017-08-19' AND MASJID_ID=1  AND MAGRIB >=(SELECT MAGRIB FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY MAGRIB) ))WHERE  DATE = '2017-08-19' AND MASJID_ID=1 

			UPDATE jamat_time SET ISHA= (SELECT ISHA FROM temp_jamat_time WHERE  DATE = '2017-08-19' AND MASJID_ID=1 AND ISHA >= (SELECT ISHA FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY ISHA having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE = '2017-08-19' AND MASJID_ID=1 AND ISHA >=(SELECT ISHA FROM salat_time WHERE DATE = '2017-08-19' ) GROUP BY ISHA) ))WHERE  DATE = '2017-08-19' AND MASJID_ID=1


INSERT into jamat_time( MASJID_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE  DATE = $date AND MASJID_ID=1 AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE =  $date ) GROUP BY FAJR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE =  $date AND MASJID_ID=1 AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE =  $date ) GROUP BY FAJR) )
			*/
			//$sqll = "SELECT "
			$fajr_sql = "INSERT into jamat_time( MASJID_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE  DATE = $date AND MASJID_ID=$mas AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE =  $date ) GROUP BY FAJR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE =  $date AND MASJID_ID=$mas AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE =  $date ) GROUP BY FAJR) )";
            $fajr_query = $this->db->pdo->prepare($fajr_sql);
			$fajr_result =$fajr_query->execute();

			//$fajr_result = $fajr_query->fetch(PDO::FETCH_ASSOC);
			//echo $fajr_result['FAJR'];


			$duhur_sql="UPDATE jamat_time SET DUHUR= (SELECT DUHUR FROM temp_jamat_time WHERE DATE =  $date AND MASJID_ID=$mas AND DUHUR >= (SELECT DUHUR FROM salat_time WHERE DATE =  $date ) GROUP BY DUHUR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE =  $date AND MASJID_ID=$mas  AND DUHUR >=(SELECT DUHUR FROM salat_time WHERE DATE =  $date ) GROUP BY DUHUR) ))WHERE DATE =  $date AND MASJID_ID=$mas ";

             $duhur_query = $this->db->pdo->prepare($duhur_sql);
			$duhur_result = $duhur_query->execute();

			// $duhur_result = $duhur_query->fetch(PDO::FETCH_ASSOC);
			//echo $duhur_result;

            $asr_sql="UPDATE jamat_time SET ASR= (SELECT ASR FROM temp_jamat_time WHERE  DATE =  $date AND MASJID_ID=$mas AND ASR >= (SELECT ASR FROM salat_time WHERE DATE =  $date ) GROUP BY ASR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE =  $date AND MASJID_ID=$mas  AND ASR >=(SELECT ASR FROM salat_time WHERE DATE =  $date ) GROUP BY ASR) ))WHERE  DATE =  $date AND MASJID_ID=$mas ";

           $asr_query = $this->db->pdo->prepare($asr_sql);
			$asr_result =$asr_query->execute();

			//$asr_result = $asr_query->fetch(PDO::FETCH_ASSOC);
			//echo $asr_result;



			$magrib_sql="UPDATE jamat_time SET MAGRIB= (SELECT MAGRIB FROM temp_jamat_time WHERE DATE =  $date AND MASJID_ID=$mas  AND MAGRIB >= (SELECT MAGRIB FROM salat_time WHERE DATE =  $date ) GROUP BY MAGRIB having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE =  $date AND MASJID_ID=$mas  AND MAGRIB >=(SELECT MAGRIB FROM salat_time WHERE DATE = $date ) GROUP BY MAGRIB) ))WHERE  DATE =  $date AND MASJID_ID=$mas ";
            $magrib_query = $this->db->pdo->prepare($magrib_sql);
			$magrib_result =$magrib_query->execute();

			//$magrib_result = $magrib_query->fetch(PDO::FETCH_ASSOC);
			//echo $magrib_result;



			$isha_sql="UPDATE jamat_time SET ISHA= (SELECT ISHA FROM temp_jamat_time WHERE  DATE =  $date AND MASJID_ID=$mas AND ISHA >= (SELECT ISHA FROM salat_time WHERE DATE =  $date ) GROUP BY ISHA having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE =  $date AND MASJID_ID=$mas AND ISHA >=(SELECT ISHA FROM salat_time WHERE DATE =  $date ) GROUP BY ISHA) ))WHERE  DATE =  $date AND MASJID_ID=$mas";
			
			 $isha_query = $this->db->pdo->prepare($isha_sql);
			 $isha_result =$isha_query->execute();

			//$isha_result = $isha_query->fetch(PDO::FETCH_ASSOC);
			//echo $isha_result;



          }   

			if($fajr_result== true AND $duhur_result==true AND $asr_result==true AND $magrib_result==true AND $isha_result==true){
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, Data have Inserted Into Jamat_Table Successfully!!</h3></div></div></div>";
				//echo $mas;
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
				//echo $mas;
				return $msg;
			}
		
		}
	}

?>