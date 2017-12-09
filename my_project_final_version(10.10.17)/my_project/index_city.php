<?php

    $val = array("January","February","March","April","May","June","July","August","September","October","November","December");
    $ind = 0;
    $month = "<option value=''>Select month</option>";
    while($ind < 12){
      $month .= "<option value='$val[$ind]' style='color: #0d47a1;'>$val[$ind]</option>";
      $ind++;
    }
    echo $month;
?>