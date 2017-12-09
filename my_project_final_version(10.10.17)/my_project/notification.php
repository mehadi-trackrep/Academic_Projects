

 <div class="col-sm-8" id="alert_popover">
  <div class="wrapper">
   <div class="content" style="color: black;">
   </div>
  </div>
 </div>


  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script>
    $(document).ready(function(){
      //alert("hemm");
      setInterval(function(){
      load_last_notification();
     }, 3500);
      
      //alert("check=");

      function load_last_notification(){
    /*

        var country = <?php echo $country ?>;
        var district = <?php echo $district ?>;
        var masjid_name = <?php echo $masjid_name ?>;
    */
        alert("check -- ");
        $.ajax({
            url: "fetch.php",
            //data: {'country':country, 'district':district, 'masjid_name':masjid_name},
            method: "GET",
            success:function(data){
              //$('.content').html(data);
              alert(data);
            },
        });
      }

    });

</script>
