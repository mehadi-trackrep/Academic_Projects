function getLocation(){
    //alert(1);
    if(navigator.geolocation){
      navigator.geolocation.getCurrentPosition(showPosition);
    }else{
      window.alert("not support");
    }
  }

  function showPosition(position){

    var lat1 = position.coords.latitude;
    var lon1 = position.coords.longitude;

    //window.alert(lat1+" "+lon1);

    $.ajax({
      url: 'use_current_location.php',
      data: {'lat1':lat1,'lon1':lon1},
      type: 'POST',
      success: function(data){
        //console.log(data);
        //$('#check').html(data);
      }
    });
  }

