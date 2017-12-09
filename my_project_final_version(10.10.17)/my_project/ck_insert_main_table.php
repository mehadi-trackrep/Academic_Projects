<?php

/*


INSERT into jamat_time( MASJID_ID,DIS_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,DIS_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE  DATE = '2017-10-10' AND MASJID_ID='1' AND DIS_ID = '1' AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE =  '2017-10-10' ) GROUP BY FAJR
						 having 
						 (
                             ( COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE =  '2017-10-10' AND MASJID_ID='1' AND DIS_ID = '1' AND 
                                                FAJR >=(SELECT FAJR FROM salat_time WHERE DATE =  '2017-10-10' ) GROUP BY FAJR) )

                             AND (    FAJR<= all(SELECT MIN(FAJR) FROM temp_jamat_time WHERE DATE = '2017-10-10' AND MASJID_ID='1' AND DIS_ID = '1' 
                                                 AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '2017-10-10' ) GROUP BY FAJR 

                                                 having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '2017-10-10' AND MASJID_ID='1' AND DIS_ID = '1' 
                                                                            AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE = '2017-10-10' ) GROUP BY FAJR) )) 
                                                )
                                 )
                         )


*/



	//include 'User.php';
	  //Session::checkSession();
	//$user = new User();


	$date = date("Y-m-d", strtotime("+1 day")); /// rat 12 tar por automatically update hobe:  => then date("Y-m-d", strtotime("-1 day"));

	//echo "date: ".$date."<br>";

	$dis_id_sql="SELECT * FROM district";
	$dis_query = $user->db->pdo->prepare($dis_id_sql);
	$dis_query->execute();

	while($dis_result = $dis_query->fetch(PDO::FETCH_ASSOC)){ 

		$dis_id = $dis_result['DIS_ID'];

		//echo "dis_id: ".$dis_id."<br>"; // .....................................

		$masjid_id_sql = "SELECT MASJID_ID FROM masjid WHERE DIS_ID = '$dis_id'";
		$masjid_query = $user->db->pdo->prepare($masjid_id_sql);
		$masjid_query->execute();
		
		while($masjid_result = $masjid_query->fetch(PDO::FETCH_ASSOC))
		{
			$mas = $masjid_result['MASJID_ID'];

			//echo "masjid_id: ".$mas."<br>";

			//date check ...
			$sql = "SELECT DATE FROM jamat_time WHERE DATE='$date' AND MASJID_ID='$mas'";
			$query = $user->db->pdo->prepare($sql);
			$query->execute();
			$res = $query->fetch(PDO::FETCH_ASSOC);

			//echo "DATE: ".$res['DATE']; // ========================================

			$sql_fajr = "SELECT DIS_ID,date,MASJID_ID FROM jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas'AND DIS_ID = '$dis_id'";
			$query_fajr = $user->db->pdo->prepare($sql_fajr);
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


	            $fajr_query = $user->db->pdo->prepare($fajr_sql);
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


	            $fajr_query = $user->db->pdo->prepare($fajr_sql);
	            $fajr_result = $fajr_query->execute();   
				
			}



			$duhur_sql="UPDATE jamat_time SET DHUHR= (SELECT DHUHR FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE =  
			'$date' ) GROUP BY DHUHR
			 having ( 
			 (  COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' 
			 AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR))


	               AND (DHUHR<= all(SELECT MIN(DHUHR) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id'  AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR) ))) )


			 ))WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DIS_ID = '$dis_id' ";


	        $duhur_query = $user->db->pdo->prepare($duhur_sql);
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


	       $asr_query = $user->db->pdo->prepare($asr_sql);
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


	        $magrib_query = $user->db->pdo->prepare($magrib_sql);
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


			
			 $isha_query = $user->db->pdo->prepare($isha_sql);
			 $isha_result = $isha_query->execute();

	    }

	}

	if($fajr_result == true AND $duhur_result == true AND $asr_result == true AND $magrib_result == true AND $isha_result == true){
		$msg_main = "<div class='container'><div class='col-sm-8'><div class='alert alert-success'><h4><strong>Success! </strong>Thank you, Data have Inserted Into Jamat_Table Successfully!!</h4></div></div></div>";
	    echo $msg_main;
		//return $msg;
	}else{
		$msg_main = "<div class='container'><div class='col-sm-8'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
		echo $msg_main;
	//return $msg;
	}


?>