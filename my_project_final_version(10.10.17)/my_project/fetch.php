<?php
    
    
    include 'User.php';
  	$user = new User();

  	//$masjid_name = $_POST['masjid_name'];
    
    /*$country = $_POST['country'];//Session::get('country');
    $district = $_POST['district'];//Session::get('district');
    $masjid_name = $_POST['masjid_name'];//Session::get('masjid_name');
    */
  	$country = Session::get("country");
  	$district = Session::get("district");
  	$masjid_name = Session::get("masjid_name");
    //$masjid_name = $_SESSION['masjid_name'];

  	$date = date("Y-m-d");
  	$p_time = date("H:i:s");

  	$sql = "SELECT DIS_ID FROM district WHERE COUNTRY LIKE '$country' AND DISTRICT LIKE '$district'";
  	$query = $user->db->pdo->prepare($sql);
  	$query->execute();
  	$result = $query->fetch(PDO::FETCH_OBJ);

  	$dis_id = $result['DIS_ID'];

  	if(isset($masjid_name) && $masjid_name != ""){
  		$sql1 = "SELECT * FROM jamat_time WHERE DIS_ID='$dis_id' AND MASJID_NAME LIKE '$masjid_name' AND DATE = '$date'";
  		$query = $user->db->pdo->prepare($sql1);
  		$query->execute();
  		$result = $query->fetch(PDO::FETCH_OBJ);
  		echo "<h4>Fajr jamat time: {$result['FAJR']}</h4>";
  	}else{
        echo "Error!! data have not been founded! "." Masjid Name:=> ".$masjid_name." date: ".$date." time: ".$p_time;
    }

?>
