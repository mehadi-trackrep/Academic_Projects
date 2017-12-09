<form action="" method="POST">

        <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
          <label class="col-xs-1 control-label">Country</label>
          <div class="col-xs-3 selectContainer">
              <input type=hidden name="st" value=0>
              <select class="form-control" name="country" id="index_country" style="color: #0d47a1;">
                <option value="">CHOOSE A COUNTRY--</option>

  <?php

    $sql = "SELECT DISTINCT COUNTRY FROM district";
    $query = $user->db->pdo->prepare($sql);
    $query->execute();

    if($query){

    while ($sql_res = $query->fetch(PDO::FETCH_ASSOC)) {

  ?>

      <option value="<?php echo $sql_res["COUNTRY"]; ?>" 
          <?php 
              if(isset($_REQUEST["country"])){
                  if ($sql_res["COUNTRY"] == $_REQUEST["country"]) {
                    echo "Selected";
                  } 
              }
          ?> >
          <?php echo $sql_res["COUNTRY"]; ?>
            
    </option>

  <?php

  }
  }

  ?>
            </select>
        </div>
      </div>

      <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
        <label class="col-xs-1 control-label">City</label>
        <div class="col-xs-3 selectContainer">
            <input type=hidden name="st" value=0>
            <select class="form-control" name="district" id="index_city" style="color: #0d47a1;">
              <option value="">CHOOSE A CITY--</option>
            </select>
        </div>
      </div>

      <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
        <label class="col-xs-1 control-label">Month</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="month" id="index_month" style="color: #0d47a1;" >
                <option value="">CHOOSE A MONTH--</option>
            </select>
        </div>
      </div>

      <div class="container" style="margin:5px 0px 10px;font-family:Courier;font-size:20px;">
        <label class="col-xs-1 control-label">Day</label>
        <div class="col-xs-3 selectContainer">
            <select class="form-control" name="day" id="index_day" style="color: #0d47a1;" onfocus='this.size=3;'> 
                <option value="">CHOOSE A DAY--</option> 
            </select><!-- For select tag => onfocus='this.size=10;' onblur='this.size=1;' 
        onchange='this.size=1; this.blur();' -->
        </div>
      </div>

    </form>
