
  /*
  function handleClick(cb){
    alert("dsfsd");
    clocation();
  }
  */

  function initialize() {
      var lat = <?php echo $a ?>;
      var lon = <?php echo $b ?>;

      var mapOptions = {
          zoom: 10,
          center: new google.maps.LatLng(lat,lon)
      };
      var map = new google.maps.Map(document.getElementById('map-canvas'),
              mapOptions);

      // Add 1 marker to the map at one location
      // bms developer group
      var location = new google.maps.LatLng(lat,lon);
      var position = new google.maps.LatLng(location.lat(), location.lng());

      var marker = new google.maps.Marker({
          position: position,
          map: map
      });
      marker.setTitle((1).toString());
      attachSecretMessage(marker);
  }
  // The five markers show a secret message when clicked
  // but that message is not within the marker's instance data
  function attachSecretMessage(marker) {
      var message = 'BMS Developer Group';
      var infowindow = new google.maps.InfoWindow({
          content: message
      });
      google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(marker.get('map'), marker);
      });
  }
  google.maps.event.addDomListener(window, 'load', initialize);