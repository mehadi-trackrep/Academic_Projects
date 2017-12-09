<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Using closures in event listeners</title>
        <style>
            html, body, #map-canvas {
                height: 100%;
                margin: 0px;
                padding: 0px
            }
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvsk8zdYYcqbjjIUBWDbVwnxCBDjJvBrI&callback=myMap"></script>
        
    </head>
    <body>
        <div id="map-canvas"></div>

        <?php
            $a = 24.908930;
            $b = 91.837902;

        ?>

        <script>
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
        </script>

    </body>
</html>