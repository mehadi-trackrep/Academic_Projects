<?php
    require 'User.php';
    $user = new User();


if( (isset($_POST['dis_id']) && isset($_POST['masjid'])) ){


    $sql = "SELECT * FROM jamat_time WHERE DIS_ID='$dis_id' AND MASJID_NAME LIKE '$masjid'";
    $query = $user->db->pdo->prepare($sql);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);

    $fajr = $res['FAJR'];
    $dhuhr = $res['DHUHR'];
    $asr = $res['ASR'];
    $magrib = $res['MAGRIB'];
    $isha = $res['ISHA'];
   

    $result = "<table class='table table-inverse col-sm-8' style='margin-top: 20px; background-color: black;'>";
    
    $result .= "<tr><th style='background-color: green;color: white;'>MASJID NAME:</th><th style='background-color: green;color: white;'>{$masjid}</th></tr>";

    $result .= "<tr><th style='background-color: green;color: white;'>SALAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";
    $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'>{$fajr} AM</td></tr>";
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