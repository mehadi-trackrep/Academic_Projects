<?php

	$mas = 1 ;
	$date = date("Y-m-d", strtotime("0 day"));

	echo $date;

	$fajr_sql = "INSERT into jamat_time( MASJID_ID,date,MASJID_NAME,FAJR) SELECT MASJID_ID,date,MASJID_NAME,FAJR FROM temp_jamat_time WHERE  DATE = '$date' AND MASJID_ID='$mas' AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE =  '$date' ) GROUP BY FAJR having ((
	 COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE =  '$date' ) GROUP BY FAJR) )
	
	 AND (FAJR<= all(SELECT MIN(FAJR) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID=
	 '$mas' AND FAJR >= (SELECT FAJR FROM salat_time WHERE DATE = '$date' ) GROUP BY FAJR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND FAJR >=(SELECT FAJR FROM salat_time WHERE DATE =
	  '$date' ) GROUP BY FAJR) ))) ))";


    $fajr_query = $this->db->pdo->prepare($fajr_sql);
	$fajr_result = $fajr_query->execute();

	//$fajr_result = $fajr_query->fetch(PDO::FETCH_ASSOC);
	//echo $fajr_result['FAJR'];


	$duhur_sql="UPDATE jamat_time SET DHUHR= (SELECT DHUHR FROM temp_jamat_time WHERE DATE =  '$date' AND MASJID_ID='$mas' AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE =  
	'$date' ) GROUP BY DHUHR
	 having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID=1  AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR))
           AND (DHUHR<= all(SELECT MIN(DHUHR) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DHUHR >= (SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR  having ( (COUNT(*) >= ALL (SELECT COUNT(*) FROM temp_jamat_time WHERE DATE = '$date' AND MASJID_ID='$mas' AND DHUHR >=(SELECT DHUHR FROM salat_time WHERE DATE = '$date' ) GROUP BY DHUHR) ))) )
	 ))WHERE DATE =  '$date' AND MASJID_ID='$mas' ";


     $duhur_query = $this->db->pdo->prepare($duhur_sql);
	$duhur_result = $duhur_query->execute();

	if($fajr_result == true AND $duhur_result == true){
		$msg = "<div class='container'><div class='col-sm-8'><div class='alert alert-success'><h4><strong>Success! </strong>Thank you, Data have Inserted Into Jamat_Table Successfully!!</h4></div></div></div>";
	//echo $mas;
		return $msg;
	}else{
		$msg = "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h3><strong>Error! </strong>Sorry, there have been a inserting problem of your details</h3></div></div></div>";
		//echo $mas;
		return $msg;
	}


?>