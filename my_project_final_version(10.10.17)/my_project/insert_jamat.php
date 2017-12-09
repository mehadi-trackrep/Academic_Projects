<?php
  include 'insert_jamat_header.php';
  //include 'header.php';
  include 'User.php';
  $user = new User();
  Session::checkLogin();
?>

  <?php

    //include 'insert_jamat_heading.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_jamat_time'])){
      $msg = $user->inserting_jamat_time_validation($_POST);
    }


  /*
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_main_jamat_time'])){
      $msg1 = $user->inserting_main_jamat_time_validation($_POST);
    }
  */
    include 'insert_jamat_body.php';

  ?>



<!--  END NAVIGATION BAR DIV TAG -->
</div>

  <script>
    function insert_notification() {
        alert("Please, Insert your data for tomorrow!!");
    }
  </script>

