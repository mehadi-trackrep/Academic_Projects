<?php
	require 'User.php';
	$user = new User();

  $c = $_POST['country'];
  $d = $_POST['city'];

  $sql = "SELECT DIS_ID FROM district WHERE COUNTRY = :c AND DISTRICT = :d";
  $query = $user->db->pdo->prepare($sql);
  $query->bindParam(':c', $c, PDO::PARAM_STR);
  $query->bindParam(':d', $d, PDO::PARAM_STR);
  //$query->bindValue(':c', $c);
  //$query->bindValue(':d', $d);
  $query->execute();

  $dis_id = $query->fetch(PDO::FETCH_ASSOC);
  $val = $dis_id['DIS_ID'];

	$sql = "SELECT DISTINCT(MASJID_NAME) FROM masjid WHERE DIS_ID = {$val}"; 
  $query = $user->db->pdo->prepare($sql);
  $query->execute();

  if($query){
    $masjid = "<option value=''>Select masjid name--</option>";
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
      $masjid .= "<option value='{$row['MASJID_NAME']}'>{$row['MASJID_NAME']}</option>";
    }
  }

  echo $masjid;
?>