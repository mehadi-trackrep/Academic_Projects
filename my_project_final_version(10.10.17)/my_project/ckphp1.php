<?php
	
	$month = "February";

	$val = array("January","February","March","April","May","June","July","August","September","October","November","December");


	function number_of_days($x){
		return 28 + ($x + floor($x/8)) % 2 + 2 % $x + 2 * floor(1/$x); 
	}

	$ind = 0;
	$num_day = 0;
	
    while($ind < 12){
      if($month == $val[$ind]){
      	$num_day = number_of_days($ind+1);
      	break;
      }
      $ind++;
    }

    $value = 1;
    /*$day = "<select>";
    $day = "<option value=''>Select day</option>";*/
    while($value<=$num_day){
    	echo "bal=>".$value."<br>";
      //$day .= "<option value='$value' style='color: #0d47a1;'>$value</option>";
      $value++;
    }
    $day = "</select>";
    echo $day;
?>