<?php
  require 'User.php';
  $user = new User();

    $c = $_POST['country'];
    $d = $_POST['city'];
    $m = $_POST['month'];
    $da = $_POST['day'];

    if(is_numeric($da)){

        $val = array("January","February","March","April","May","June","July","August","September","October","November","December");
        
        $ii = 0;
        while ($m != $val[$ii]) {
          $ii++;
        }

        $m = ++$ii;

        $sql = 'SELECT DIS_ID FROM district WHERE COUNTRY = :c AND DISTRICT = :d';

        $res = $user->db->pdo->prepare($sql);
        $res->bindParam(':c', $c, PDO::PARAM_STR);
        $res->bindParam(':d', $d, PDO::PARAM_STR);
        $res->execute();
        $val = $res->fetch(PDO::FETCH_ASSOC);

        $salat_result = "";

        if($val){
          $sql2 = "SELECT * FROM salat_time WHERE DIS_ID = {$val['DIS_ID']} AND MONTH = $m AND DAY = $da"; // SQL A PROBLEM ACE MAY BE...
          $salat_result = $user->db->pdo->prepare($sql2);
          $salat_result->execute();
        }
          
        $show_salat = $salat_result->fetch(PDO::FETCH_ASSOC);

        if(!$show_salat){
            echo "<div class='container'><div class='col-sm-6'><div class='alert alert-danger'><h4><strong>Error! </strong>Data have not found!!</h4></div></div></div>\n";
            
            $result = "<table class='table table-inverse col-sm-8' style='margin-top: 20px;background-color: black;'>";

            $result .= "<tr><th style='background-color: green;color: white;'>SALAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";

            $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'></td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>SUNRISE</th><td class='col-sm-3'></td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>DHUHR</th><td class='col-sm-3'></td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>ASR</th><td class='col-sm-3'></td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>MAGRIB</th><td class='col-sm-3'></td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'></td></tr>";
            $result .= "</table>";

            echo $result;

        }else{

            $result = "<table class='table table-inverse col-sm-8' style='margin-top: 20px; background-color: black;'>";

            $result .= "<tr><th style='background-color: green;color: white;'>SALAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";

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

            $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'>{$fajr} AM</td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>SUNRISE</th><td class='col-sm-3'>{$sunrise} AM</td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>DHUHR</th><td class='col-sm-3'>{$dhuhr} PM</td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>ASR</th><td class='col-sm-3'>{$asr} PM</td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>MAGRIB</th><td class='col-sm-3'>{$magrib} PM</td></tr>";
            $result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'>{$isha} PM</td></tr>";

            /*$result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'>{$show_salat['ISHA']} PM</td></tr>";
            */
            $result .= "</table>";

            echo $result;
        }
    }
    else{
        $result = "<table class='table table-inverse col-sm-8' style='margin-top: 20px; background-color: black;'>";

        $result .= "<tr><th style='background-color: green;color: white;'>SALAT NAME</th><th style='background-color: green;color: white;'>START TIME</th></tr>";

        $result .= "<tr style='color: white;'><th class='col-sm-3'>FAJR</th><td class='col-sm-3'></td></tr>";
        $result .= "<tr style='color: white;'><th class='col-sm-3'>SUNRISE</th><td class='col-sm-3'></td></tr>";
        $result .= "<tr style='color: white;'><th class='col-sm-3'>DHUHR</th><td class='col-sm-3'></td></tr>";
        $result .= "<tr style='color: white;'><th class='col-sm-3'>ASR</th><td class='col-sm-3'></td></tr>";
        $result .= "<tr style='color: white;'><th class='col-sm-3'>MAGRIB</th><td class='col-sm-3'></td></tr>";
        $result .= "<tr style='color: white;'><th class='col-sm-3'>ISHA</th><td class='col-sm-3'></td></tr>";
        $result .= "</table>";

        echo $result;
    }

?>
