<?php

	//FAJR JAMAT TIME
    $fajr_hour = array("04","05","06");
    $ind = 0;
    $fajr_hour1 = "<option value=''>CHOOSE A HOUR--</option>";
    while($ind < 3){
      $fajr_hour1 .= "<option value='$fajr_hour[$ind]'>$fajr_hour[$ind]</option>";
      $ind++;
    }

    $fajr_minute = array("00","05","10","15","20","25","30","35","40","45","50","55");
    $ind = 0;
    $fajr_minute1 = "<option value=''>CHOOSE A MINUTE--</option>";
    while($ind < 12){
      $fajr_minute1 .= "<option value='$fajr_minute[$ind]'>$fajr_minute[$ind]</option>";
      $ind++;
    }

/*
    $fajr_am = array("AM");
    $ind = 0;
    $fajr_am1 = "<option value=''>CHOOSE AM/PM--</option>";
    while($ind < 1){
      $fajr_am1 .= "<option value='$fajr_am[$ind]'>$fajr_am[$ind]</option>";
      $ind++;
    }
*/

// DUHUR JAMAT TIME


    $duhur_hour = array("12","01","02");
    $ind = 0;
    $duhur_hour1 = "<option value=''>CHOOSE A HOUR--</option>";
    while($ind < 3){
      $duhur_hour1 .= "<option value='$duhur_hour[$ind]'>$duhur_hour[$ind]</option>";
      $ind++;
    }

    $duhur_minute = array("00","05","10","15","20","25","30","35","40","45","50","55");
    $ind = 0;
    $duhur_minute1 = "<option value=''>CHOOSE A MINUTE--</option>";
    while($ind < 12){
      $duhur_minute1 .= "<option value='$duhur_minute[$ind]'>$duhur_minute[$ind]</option>";
      $ind++;
    }

/*
    $duhur_am = array("PM");
    $ind = 0;
    $duhur_am1 = "<option value=''>CHOOSE AM/PM--</option>";
    while($ind < 1){
      $duhur_am1 .= "<option value='$duhur_am[$ind]'>$duhur_am[$ind]</option>";
      $ind++;
    }
*/

//ASR JAMAT TIME

    $asr_hour = array("04","05","06");
    $ind = 0;
    $asr_hour1 = "<option value=''>CHOOSE A HOUR--</option>";
    while($ind < 3){
      $asr_hour1 .= "<option value='$asr_hour[$ind]'>$asr_hour[$ind]</option>";
      $ind++;
    }

    $asr_minute = array("00","05","10","15","20","25","30","35","40","45","50","55");
    $ind = 0;
    $asr_minute1 = "<option value=''>CHOOSE A MINUTE--</option>";
    while($ind < 12){
      $asr_minute1 .= "<option value='$asr_minute[$ind]'>$asr_minute[$ind]</option>";
      $ind++;
    }
/*
    $asr_am = array("PM");
    $ind = 0;
    $asr_am1 = "<option value=''>CHOOSE AM/PM--</option>";
    while($ind < 1){
      $asr_am1 .= "<option value='$asr_am[$ind]'>$asr_am[$ind]</option>";
      $ind++;
    }

*/
    //MAGRIB JAMAT TIME


    $magrib_hour = array("05","06","07");
    $ind = 0;
    $magrib_hour1 = "<option value=''>CHOOSE A HOUR--</option>";
    while($ind < 3){
      $magrib_hour1 .= "<option value='$magrib_hour[$ind]'>$magrib_hour[$ind]</option>";
      $ind++;
    }

    $magrib_minute = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15",
      "15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35",
      "36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
    $ind = 0;
    $magrib_minute1 = "<option value=''>CHOOSE A MINUTE--</option>";
    while($ind < 61){
      $magrib_minute1 .= "<option value='$magrib_minute[$ind]'>$magrib_minute[$ind]</option>";
      $ind++;
    }

/*
    $magrib_am = array("PM");
    $ind = 0;
    $magrib_am1 = "<option value=''>CHOOSE AM/PM--</option>";
    while($ind < 1){
      $magrib_am1 .= "<option value='$magrib_am[$ind]'>$magrib_am[$ind]</option>";
      $ind++;
    }

*/


    //ISHA JAMAT TIME



    $isha_hour = array("07","08","09");
    $ind = 0;
    $isha_hour1 = "<option value=''>CHOOSE A HOUR--</option>";
    while($ind < 3){
      $isha_hour1 .= "<option value='$isha_hour[$ind]'>$isha_hour[$ind]</option>";
      $ind++;
    }

    $isha_minute = array("00","05","10","15","20","25","30","35","40","45","50","55");
    $ind = 0;
    $isha_minute1 = "<option value=''>CHOOSE A MINUTE--</option>";
    while($ind < 12){
      $isha_minute1 .= "<option value='$isha_minute[$ind]'>$isha_minute[$ind]</option>";
      $ind++;
    }
/*
    $isha_am = array("PM");
    $ind = 0;
    $isha_am1 = "<option value=''>CHOOSE AM/PM--</option>";
    while($ind < 1){
      $isha_am1 .= "<option value='$isha_am[$ind]'>$isha_am[$ind]</option>";
      $ind++;
    }
*/


?>


