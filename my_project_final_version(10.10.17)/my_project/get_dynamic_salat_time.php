<?php
    require 'User.php';
    $user = new User();


if( (isset($_POST['c']) && isset($_POST['d'])) || true){

    if(isset($country) && isset($district) ){
        $country = $_POST['c'];
        $str = $_POST['d'];
        $district = rtrim($str,"District");
    }

    //echo $country." ".$district;
    $country="Bangladesh"; // ..........................
    $district="Sylhet";    // ..........................



    $sql = "SELECT DIS_ID FROM district WHERE COUNTRY = :country AND DISTRICT = :district";
    $query = $user->db->pdo->prepare($sql);
    //$query = $dbo->prepare($sql);
    $query->bindValue(':country',$country);
    $query->bindValue(':district',$district);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);
    $dis_id = $res['DIS_ID'];

    //$month = 2;  ///  ============================================(change kora lagbo..)
    $month = date('m');
    $day =  Date('d');

    $sql = "SELECT * FROM salat_time WHERE DIS_ID = :dis_id AND MONTH = :month AND DAY = :day";
    $query = $user->db->pdo->prepare($sql);
    $query->bindValue(':dis_id',$dis_id);
    $query->bindValue(':month',$month);
    $query->bindValue(':day',$day);
    $query->execute();
    $show_salat = $query->fetch(PDO::FETCH_ASSOC);

    $var = new DateTime($show_salat['FAJR']);
    // $var1 = $var->format('h:i a'); a means AM/PM
    $fajr = $var->format('h:i');

    $var = new DateTime($show_salat['SUNRISE']);
    $sunrise = $var->format('h:i');

    $var = new DateTime($show_salat['DHUHR']);
    $dhuhr = $var->format('h:i');

    $var = new DateTime($show_salat['ASR']);
    $asr = $var->format('h:i');

    $var = new DateTime($show_salat['MAGRIB']);
    $magrib = $var->format('h:i');
    
    $var = new DateTime($show_salat['ISHA']);            
    $isha = $var->format('h:i');

    $result = "<table class='table table-inverse col-sm-8' style='margin-top: 20px; background-color: black;'>";
    
    $result .= "<tr><th style='background-color: green;color: white;'>DISTRICT, COUNTRY</th><th style='background-color: green;color: white;'>{$district}, {$country}</th></tr>";

    $result .= "<tr><th style='background-color: green;color: white;'>SALAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'>{$fajr} AM</td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>SUNRISE</th><td class='col-sm-3'>{$sunrise} AM</td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>DHUHR</th><td class='col-sm-3'>{$dhuhr} PM</td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>ASR</th><td class='col-sm-3'>{$asr} PM</td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>MAGRIB</th><td class='col-sm-3'>{$magrib} PM</td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'>{$isha} PM</td></tr>";

    $result .= "</table>";
    
    echo $result;
}
else{
    
    $result = "Hmm, there geolocation ajax can not give the country and city >:(";

/*
    $result = "<table class='table table-inverse col-sm-8' style='margin-top: 20px; background-color: black;'>";

    $result .= "<tr><th style='background-color: green;color: white;'>SALAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'></td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>SUNRISE</th><td class='col-sm-3'></td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>DHUHR</th><td class='col-sm-3'></td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>ASR</th><td class='col-sm-3'></td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>MAGRIB</th><td class='col-sm-3'></td></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'></td></tr>";

    $result .= "</table>";
*/

    echo $result;
}

    
?>