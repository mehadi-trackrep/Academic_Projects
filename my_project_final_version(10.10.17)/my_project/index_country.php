<?php
    require 'User.php';
    $user = new User();

    $country = $_POST['country'];
    
    //$sql = "SELECT DISTRICT FROM district WHERE COUNTRY = '$country'";
    $sql = "SELECT DISTRICT FROM district WHERE COUNTRY = :country  ORDER BY DIS_ID ASC";
    $query = $user->db->pdo->prepare($sql);
    
    $query->bindValue(':country',$country);
    $query->execute();

    $str = "<option value=''>Select city</option>";
    while ($sql_res = $query->fetch(PDO::FETCH_ASSOC)) {
        $str = $str."<option value='{$sql_res['DISTRICT']}'>{$sql_res['DISTRICT']}</option>";
    }
    echo $str;
    
?>