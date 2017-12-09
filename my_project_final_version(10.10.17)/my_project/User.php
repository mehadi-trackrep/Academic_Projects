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
			$country    = $data['country'];
			$masjid_name = $data['masjid'];
			$district 	= $data['district'];
			$password 	= $data['password'];
			$cpassword 	= $data['cpassword'];

			//$password 	= md5($data['password']);
			//$cpassword 	= md5($data['cpassword']);

			$ck_email = $this->emailCheck($email);

			if($username == "" OR $email == "" OR $country == "" OR $masjid_name == "" OR $district == "" OR $password == "" OR $cpassword == ""){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			if(strlen($username) < 5){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Username is too short</h3></div></div></div>";
				return $msg;
			}

			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}

			if($ck_email == true){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>The email already exists</h3></div></div></div>";
				return $msg;
			}

			if($password != $cpassword){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Confirm password did not match!</h3></div></div></div>";
				return $msg;
			}

			$sql = "INSERT INTO user(USER_NAME,EMAIL,COUNTRY,MASJID_NAME,DISTRICT,PASSWORD) VALUES(:username, :email, :country, :masjid_name, :district, :password)"; // sql er khettere variable er poriborte ':'(colon) user korlei kaj hoy jay :)
			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':country',$country);
			$query->bindValue(':masjid_name',$masjid_name);
			$query->bindValue(':district',$district);
			$query->bindValue(':password',$password);
			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, you have been registered!!</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
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
			$password 	= $data['password'];

			$ck_email = $this->emailCheck($email);
			/*$ck_password = $this->passwordCheck($email);*/

			if($email == "" OR $password == ""){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must be not empty</h3></div></div></div>";
				return $msg;
			}
			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}
			if($ck_email == false){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>The email does not exist</h3></div></div></div>";
				return $msg;
			}
			$user_all_data = $this->getLoginUser($email,$password); // all datas of the user

			if($user_all_data){
				Session::init();
				Session::set("login",true);
				Session::set("user_id",$user_all_data->USER_ID);
				Session::set("email",$user_all_data->EMAIL);
				Session::set("country",$user_all_data->COUNTRY);
				Session::set("username",$user_all_data->USER_NAME);
				Session::set("masjid_name",$user_all_data->MASJID_NAME);
				Session::set("district",$user_all_data->DISTRICT);
				Session::set("loginmsg","<div class='container alert' style='color: red;font-size: 20px;background-color: darkgreen;margin-top:-480px;margin-bottom: 400px;margin-left:80px;max-width: 1000px;'><div class='col-sm-4' style='text-align: center;margin-top: -0.5em'><strong>Success! </strong>You are logged in</div> <div class='col-sm-8' style='text-align: center;size: 5;margin-top: -0.5em'><masquee behavior='scroll' direction='left'><strong>Welcome</strong>!! <font face='verdana' color='green;'><i>{$user_all_data->USER_NAME}</i></font></div></masquee></div>");
				
				header("Location: index.php");
			}else{
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger' style='background-color: lightblue;'><h3><strong>Error! </strong>Data not found</h3></div></div></div>";
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
			$password 	= $data['password'];
			$cpassword 	= $data['cpassword'];

			$ck_email = $this->emailCheckinProfile($email,$user_id);

			if($username == "" OR $email == "" OR $masjid_name == "" OR $district == "" OR $password == "" OR $cpassword == ""){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			if(strlen($username) < 5){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Username is too short</h3></div></div></div>";
				return $msg;
			}

			if(filter_var($email,FILTER_VALIDATE_EMAIL) == FALSE){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Email is not valid</h3></div></div></div>";
				return $msg;
			}

			if($ck_email == true){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>The email already exists</h3></div></div></div>";
				return $msg;
			}

			if($password != $cpassword){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Confirm password did not match!</h3></div></div></div>";
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
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-success'><h3><strong>Success! </strong>Userdata Updated Successfully.</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Userdata Not Updated!.</h3></div></div></div>";
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
/*
			if(Session::get('masjid_name') != $masjid){
				$ck = false;
			}else{
				$ck = true;
			}

			if($ck == false){
				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Alert!! </strong>Only relevant user of the masjid can give the data.</h3></div></div></div>";
				return $msg;
			}
*/
			$fajr_hour1 	= $data['fajr_hour1'];
			$fajr_minute1  	= $data['fajr_minute1'];
			//$fajr_am1 		= $data['fajr_am1'];

			//$fajr_str       = $fajr_hour1.":".$fajr_minute1;
			$fajr_str = date("H:i:s", strtotime($fajr_hour1.":".$fajr_minute1." AM"));

			$duhur_hour1 	= $data['duhur_hour1'];
			$duhur_minute1 	= $data['duhur_minute1'];
			//$duhur_am1 		= $data['duhur_am1'];

			//$duhur_str      = $duhur_hour1.":".$duhur_minute1;
			$duhur_str = date("H:i:s", strtotime($duhur_hour1.":".$duhur_minute1." PM"));

			$asr_hour1 		= $data['asr_hour1'];
			$asr_minute1 	= $data['asr_minute1'];
			//$asr_am1 		= $data['asr_am1'];

			//$asr_str        = $asr_hour1.":".$asr_minute1;
			$asr_str = date("H:i:s", strtotime($asr_hour1.":".$asr_minute1." PM"));

			$magrib_hour1 	= $data['magrib_hour1'];
			$magrib_minute1 = $data['magrib_minute1'];
			//$magrib_am1 	= $data['magrib_am1'];

			//$magrib_str     = $magrib_hour1.":".$magrib_minute1;
			$magrib_str = date("H:i:s", strtotime($magrib_hour1.":".$magrib_minute1." PM"));

			$isha_hour1 	= $data['isha_hour1'];
			$isha_minute1 	= $data['isha_minute1'];
			//$isha_am1 		= $data['isha_am1'];

			//$isha_str       = $isha_hour1.":".$isha_minute1;
			$isha_str = date("H:i:s", strtotime($isha_hour1.":".$isha_minute1." PM"));

			if($country == "" OR $district == ""  OR $masjid == "" OR $fajr_hour1 == "" OR $fajr_minute1 == "" OR $duhur_hour1 == "" OR $duhur_minute1 == "" OR $asr_hour1 == "" OR $asr_minute1 == "" OR $magrib_hour1 == "" OR $magrib_minute1 == "" OR $isha_hour1 == "" OR $isha_minute1 == ""){

				$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Field must not be empty</h3></div></div></div>";
				return $msg;
			}

			$sql = "SELECT DIS_ID FROM DISTRICT WHERE DISTRICT LIKE '$district' AND COUNTRY LIKE '$country'";
			$query = $this->db->pdo->prepare($sql);
			$dis_id = $query->execute();
			//$date = date("Y-m-d");
			$date = date('Y-m-d', strtotime(' +1 day'));

			$masjid_sql = "SELECT MASJID_ID FROM masjid WHERE DIS_ID = '$dis_id' AND MASJID_NAME LIKE '$masjid'";
			//$masjid_sql = "SELECT MASJID_ID FROM `masjid` WHERE MASJID_ID=2";
			$masjid_query = $this->db->pdo->prepare($masjid_sql);
			$masjid_query->execute();
			$res = $masjid_query->fetch(PDO::FETCH_ASSOC);
			$masjid_idd = $res['MASJID_ID'];

			//return $dis_id."-- ".$masjid_idd." -- ".$masjid; // ============================
			
			

			$sql = "INSERT INTO temp_jamat_time(DIS_ID,MASJID_ID,DATE,MASJID_NAME,FAJR,DHUHR,ASR,MAGRIB,ISHA) VALUES(:dis_id, :masjid_idd, :date, :masjid, :fajr_str, :duhur_str, :asr_str, :magrib_str, :isha_str)";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':dis_id',$dis_id);
			$query->bindValue(':masjid_idd',$masjid_idd);
			$query->bindValue(':date',$date);
			$query->bindValue(':masjid',$masjid);
			$query->bindValue(':fajr_str',$fajr_str);
			$query->bindValue(':duhur_str',$duhur_str);
			$query->bindValue(':asr_str',$asr_str);
			$query->bindValue(':magrib_str',$magrib_str);
			$query->bindValue(':isha_str',$isha_str);

			$result = $query->execute();

			if($result){
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-success'><h3><strong>Success! </strong>Thank you, Data have Inserted Successfully!!</h3></div></div></div>";
				return $msg;
			}else{
				$msg = "<div class='container'><div class='col-sm-10'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
				return $msg;
			}

		}

/// Some sqls :

/*	insert into jamat_time( MASJID_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY FAJR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY FAJR) )


insert into jamat_time( MASJID_ID,date,MASJID_NAME,FAJR)
SELECT MASJID_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY FAJR having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY FAJR) )
AND (FAJR<= all(SELECT MIN(FAJR) FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY FAJR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY FAJR) ))) ) )




				UPDATE jamat_time SET DHUHR= (SELECT DHUHR FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY DHUHR having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1  AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY DHUHR))
AND (DHUHR<= all(SELECT MIN(DHUHR) FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY DHUHR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1 AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY DHUHR) ))) )
				 ))WHERE DATE = '2017-08-24' AND MASJID_ID=1

				UPDATE jamat_time SET ASR= (SELECT ASR FROM temp_jamat_time WHERE  DATE = '2017-08-24' AND MASJID_ID=1 AND ASR >= (SELECT ASR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY ASR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE = '2017-08-24' AND MASJID_ID=1  AND ASR >=(SELECT ASR FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY ASR) ))WHERE  DATE = '2017-08-24' AND MASJID_ID=1 

				UPDATE jamat_time SET MAGRIB= (SELECT MAGRIB FROM temp_jamat_time WHERE DATE = '2017-08-24' AND MASJID_ID=1  AND MAGRIB >= (SELECT MAGRIB FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY MAGRIB having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE = '2017-08-24' AND MASJID_ID=1  AND MAGRIB >=(SELECT MAGRIB FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY MAGRIB) ))WHERE  DATE = '2017-08-24' AND MASJID_ID=1 

				UPDATE jamat_time SET ISHA= (SELECT ISHA FROM temp_jamat_time WHERE  DATE = '2017-08-24' AND MASJID_ID=1 AND ISHA >= (SELECT ISHA FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY ISHA having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE  DATE = '2017-08-24' AND MASJID_ID=1 AND ISHA >=(SELECT ISHA FROM salat_time WHERE DATE = '2017-08-24' ) GROUP BY ISHA) ))WHERE  DATE = '2017-08-24' AND MASJID_ID=1


	INSERT into jamat_time( MASJID_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE  DATE = $date AND MASJID_ID=1 AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE =  $date ) GROUP BY FAJR having ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE =  $date AND MASJID_ID=1 AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE =  $date ) GROUP BY FAJR) )
				*/
				//$sqll = "SELECT "




		public function insert_main_jamat_time_data(){

			$date = date("Y-m-d", strtotime("+1 day")); /// rat 12 tar por automatically update hobe:  => then date("Y-m-d", strtotime("-1 day"));

			//echo "date: ".$date."<br>";

			$dis_id_sql="SELECT * FROM district";
			$dis_query = $this->db->pdo->prepare($dis_id_sql);
			$dis_query->execute();

			while($dis_result = $dis_query->fetch(PDO::FETCH_ASSOC)){ 

				$dis_id = $dis_result['DIS_ID'];

				//echo "dis_id: ".$dis_id."<br>"; // .....................................

				$masjid_id_sql = "SELECT MASJID_ID FROM masjid WHERE DIS_ID = '$dis_id'";
				$masjid_query = $this->db->pdo->prepare($masjid_id_sql);
				$masjid_query->execute();
				
				while($masjid_result = $masjid_query->fetch(PDO::FETCH_ASSOC))
				{
					$mas = $masjid_result['MASJID_ID'];

					//echo "masjid_id: ".$mas."<br>";

					//date check ...
					$sql = "SELECT DATE FROM jamat_time WHERE DATE='$date' AND MASJID_ID='$mas'";
					$query = $this->db->pdo->prepare($sql);
					$query->execute();
					$res = $query->fetch(PDO::FETCH_ASSOC);

					//echo "DATE: ".$res['DATE']; // ========================================

					$sql_fajr = "SELECT DIS_ID,date,MASJID_ID FROM jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas'AND DIS_ID = '$dis_id'";
					$query_fajr = $this->db->pdo->prepare($sql_fajr);
					//$sql_fajr_update = "";

					// ACTUAL CODE START .................
					if(isset($res) && $res != ""){
						//echo "update works .. for masjid_id: ".$mas."<br>"; // ============================================
						$fajr_sql = "UPDATE jamat_time SET FAJR= (SELECT FAJR FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE =  
						'$date' ) GROUP BY FAJR
						 having ( 
						 (  COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' 
						 AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '$date' ) GROUP BY FAJR))

			                   AND (FAJR<= all(SELECT MIN(FAJR) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '$date' ) GROUP BY FAJR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '$date' ) GROUP BY FAJR) ))) )

						 ))WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' ";


			            $fajr_query = $this->db->pdo->prepare($fajr_sql);
						$fajr_result = $fajr_query->execute();

					}else{
						//echo "insert works .. for masjid_id: ".$mas."<br>";
						//$result_fajr = $query_fajr->execute();
						$fajr_sql = "INSERT into jamat_time( MASJID_ID,DIS_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,DIS_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE  DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE =  '$date' ) GROUP BY FAJR
						 having 
						 (
						   ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND 
						                    FAJR >=(SELECT FAJR FROM salat_time WHERE DATE =  '$date' ) GROUP BY FAJR) )
						
						 AND (    FAJR<= all(SELECT MIN(FAJR) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' 
						          AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '$date' ) GROUP BY FAJR 

						  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' 
						   AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '$date' ) GROUP BY FAJR) )) 
						     )
						   )
						)";


			            $fajr_query = $this->db->pdo->prepare($fajr_sql);
			            $fajr_result = $fajr_query->execute();   
						
					}



					$duhur_sql="UPDATE jamat_time SET DHUHR= (SELECT DHUHR FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE =  
					'$date' ) GROUP BY DHUHR
					 having ( 
					 (  COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' 
					 AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR))


			               AND (DHUHR<= all(SELECT MIN(DHUHR) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR) ))) )


					 ))WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' ";


			        $duhur_query = $this->db->pdo->prepare($duhur_sql);
					$duhur_result = $duhur_query->execute();

					// $duhur_result = $duhur_query->fetch(PDO::FETCH_ASSOC);
					//echo $duhur_result;

			        $asr_sql="UPDATE jamat_time SET ASR= (SELECT ASR FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND ASR >= (SELECT ASR FROM salat_time WHERE DATE =  
					'$date' ) GROUP BY ASR
					 having ( 
					 (  COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' 
					 AND ASR >=(SELECT ASR FROM salat_time WHERE DATE = '$date' ) GROUP BY ASR))


			               AND (ASR<= all(SELECT MIN(ASR) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND ASR >= (SELECT ASR FROM salat_time WHERE DATE = '$date' ) GROUP BY ASR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND ASR >=(SELECT ASR FROM salat_time WHERE DATE = '$date' ) GROUP BY ASR) ))) )


					 ))WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' ";


			       $asr_query = $this->db->pdo->prepare($asr_sql);
				   $asr_result =$asr_query->execute();

					//$asr_result = $asr_query->fetch(PDO::FETCH_ASSOC);
					//echo $asr_result;



					$magrib_sql="UPDATE jamat_time SET MAGRIB= (SELECT MAGRIB FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND MAGRIB >= (SELECT MAGRIB FROM salat_time WHERE DATE =  
					'$date' ) GROUP BY MAGRIB
					 having ( 
					 (  COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  
					 AND MAGRIB >=(SELECT MAGRIB FROM salat_time WHERE DATE = '$date' ) GROUP BY MAGRIB))


			               AND (MAGRIB<= all(SELECT MIN(MAGRIB) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND MAGRIB >= (SELECT MAGRIB FROM salat_time WHERE DATE = '$date' ) GROUP BY MAGRIB  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND MAGRIB >=(SELECT MAGRIB FROM salat_time WHERE DATE = '$date' ) GROUP BY MAGRIB) ))) )


					 ))WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' ";


			        $magrib_query = $this->db->pdo->prepare($magrib_sql);
					$magrib_result =$magrib_query->execute();

					//$magrib_result = $magrib_query->fetch(PDO::FETCH_ASSOC);
					//echo $magrib_result;



					$isha_sql="UPDATE jamat_time SET ISHA= (SELECT ISHA FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas'AND DIS_ID = '$dis_id'  AND ISHA >= (SELECT ISHA FROM salat_time WHERE DATE =  
					'$date' ) GROUP BY ISHA
					 having ( 
					 (  COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  
					 AND ISHA >=(SELECT ISHA FROM salat_time WHERE DATE = '$date' ) GROUP BY ISHA))


			               AND (ISHA<= all(SELECT MIN(ISHA) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND ISHA >= (SELECT ISHA FROM salat_time WHERE DATE = '$date' ) GROUP BY ISHA  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' AND ISHA >=(SELECT ISHA FROM salat_time WHERE DATE = '$date' ) GROUP BY ISHA) ))) )


					 ))WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' ";


					
					 $isha_query = $this->db->pdo->prepare($isha_sql);
					 $isha_result = $isha_query->execute();

					 

					//$isha_result = $isha_query->fetch(PDO::FETCH_ASSOC);
					//echo $isha_result;

					 // $fajr_result == true AND $duhur_result == true AND $asr_result == true AND $magrib_result == true AND $isha_result == true

					if($fajr_result == true  AND $duhur_result == true AND $asr_result == true AND $magrib_result == true AND $isha_result == true){
					$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-success'><h4><strong>Success! </strong>Thank you, Data have Inserted Into Jamat_Table Successfully!!</h4></div></div></div>";
						//echo $msg;
						return $msg;
					}else{
						$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
						//echo $msg;
						return $msg;
					}

			    }

			}

				
		}

		public function get_jamat_time_after_location_click($data){

			  $c = $data['country'];
		      $d = $data['district'];
		      $m = $data['masjid'];
		      $dd = $data['date'];

		      if($m == "") return ;

		      //echo $c." ".$d." ".$m;

		      $sql = "SELECT DIS_ID FROM district WHERE COUNTRY = :c AND DISTRICT = :d";

		      $res = $this->db->pdo->prepare($sql);

		      $res->bindParam(':c', $c, PDO::PARAM_STR);
		      $res->bindParam(':d', $d, PDO::PARAM_STR);

		      $res->execute();
		      $val = $res->fetch(PDO::FETCH_ASSOC);


		      $sql = "SELECT MASJID_ID FROM masjid WHERE DIS_ID = {$val['DIS_ID']} AND MASJID_NAME = '$m'";
		      $res = $this->db->pdo->prepare($sql);
		      $res->execute();
		      $val = $res->fetch(PDO::FETCH_ASSOC);

		      //$DATE = date("Y-m-d");
		      $DATE = $dd;
		     
		      $sql2 = "SELECT * FROM jamat_time WHERE MASJID_ID = {$val['MASJID_ID']} AND DATE ='$DATE' AND MASJID_NAME = '$m'"; // SQL A PROBLEM ACE MAY BE...

		      $salat_result = $this->db->pdo->prepare($sql2);
		      $salat_result->execute();
		      $show_salat = $salat_result->fetch(PDO::FETCH_ASSOC);

		    if(!$show_salat){
		        echo "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h4><strong>Error! </strong>Data have not found!!</h4></div></div></div>\n";

		         $result = "<table class='table table-inverse' style='margin-top: 20px;background-color: black;'>";
		         $result .= "<tr><th style='background-color: green;color: white;'>JAMAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";

		        $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'></td></tr>";
		        $result .= "<tr style='color: white;'><th class='col-sm-3'>SUNRISE</th><td class='col-sm-3'></td></tr>";
		        $result .= "<tr style='color: white;'><th class='col-sm-3'>DHUHR</th><td class='col-sm-3'></td></tr>";
		        $result .= "<tr style='color: white;'><th class='col-sm-3'>ASR</th><td class='col-sm-3'></td></tr>";
		        $result .= "<tr style='color: white;'><th class='col-sm-3'>MAGRIB</th><td class='col-sm-3'></td></tr>";
		        $result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'></td></tr>";
		        $result .= "</table>";

		        return $result;
		    }
		    else{

		        $result = "<table class='table table-inverse' style='margin-top: 20px;background-color: black;'>";
		        $result .= "<tr><th style='background-color: green;color: white;'>JAMAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";

		        $var = new DateTime($show_salat['FAJR']);
		            // $var1 = $var->format('h:i a'); a means AM/PM
		          $fajr = $var->format('h:i');

		          $var = new DateTime($show_salat['DHUHR']);
		          $dhuhr = $var->format('h:i');

		          $var = new DateTime($show_salat['ASR']);
		          $asr = $var->format('h:i');

		          $var = new DateTime($show_salat['MAGRIB']);
		          $magrib = $var->format('h:i');

		          $var = new DateTime($show_salat['ISHA']);            
		          $isha = $var->format('h:i');

		          $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'>{$fajr} AM</td></tr>";          
		          $result .= "<tr style='color: white;'><th class='col-sm-3'>DHUHR</th><td class='col-sm-3'>{$dhuhr} PM</td></tr>";
		          $result .= "<tr style='color: white;'><th class='col-sm-3'>ASR</th><td class='col-sm-3'>{$asr} PM</td></tr>";
		          $result .= "<tr style='color: white;'><th class='col-sm-3'>MAGRIB</th><td class='col-sm-3'>{$magrib} PM</td></tr>";
		          $result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'>{$isha} PM</td></tr>";
		          $result .= "</table>";

		        return $result;
		    }
		}
		
	}

?>