<?php
	require 'User.php';
	$user = new User();

	$sql = "SELECT DISTINCT(DATE) FROM jamat_time ORDER BY DATE DESC"; 
    $query = $user->db->pdo->prepare($sql);
    $query->execute();

    if($query){
      $date = "<option value=''>Select date--</option>";
      while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $date .= "<option value='{$row['DATE']}'>{$row['DATE']}</option>";
      }
    }
    
    echo $date;
?>