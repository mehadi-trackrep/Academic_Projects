<?php

  //echo "-->".$fajr;

  $var = new DateTime($self_jamat_time['FAJR']);
  // $var1 = $var->format('h:i a'); a means AM/PM
  $fajr = $var->format('h:i');

  $var = new DateTime($self_jamat_time['DHUHR']);
  $dhuhr = $var->format('h:i');

  $var = new DateTime($self_jamat_time['ASR']);
  $asr = $var->format('h:i');

  $var = new DateTime($self_jamat_time['MAGRIB']);
  $magrib = $var->format('h:i');

  $var = new DateTime($self_jamat_time['ISHA']);            
  $isha = $var->format('h:i');

?>

<table class="table table-inverse col-sm-8" id="jamat_time_table1" style="margin-top: 20px;background-color: black;">
    
    <tr>
        <th style="background-color: green;color: white;">REGISTERED MASJID NAME</th>
        <th style="background-color: green;color: white;"><?php echo $masjid_name; ?> </th>
    </tr>

    <tr>
        <th style="background-color: green;color: white;">JAMAT NAME</th>
        <th style="background-color: green;color: white;">START TIME</th>
       
    </tr>
    <tr style="color: white;">
      <th>FAJR</th>
      <td> <?php  echo $fajr." AM"; ?> </td>
  </tr>
  <tr style="color: white;">
      <th >DHUHR</th>
      <td> <?php  echo $dhuhr." PM"; ?> </td>
  </tr>
  <tr style="color: white;">
      <th >ASR</th>
      <td> <?php  echo $asr." PM"; ?> </td>
  </tr>
  <tr style="color: white;">
      <th >MAGRIB</th>
      <td> <?php echo $magrib." PM";  ?> </td>
  </tr>
  <tr style="color: white;">
      <th >ISHA</th>
      <td> <?php  echo $isha." PM"; ?> </td>
  </tr>
</table>
