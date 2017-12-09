<html>
<head>
	<title>CITY_NAME_RETRIEVE_USER</title>
</head>
<body>
	<h1>LETS trace ur location.</h1>
	<button onclick="getLocation()">Get Location</button>
	<div id ="output"></div>

<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
	var x = document.getElementById('output')	;
	//x.innerHTML = "Here is output";

	function getLocation(){
		//alert(1);
		if(navigator.geolocation){
			//x.innerHTML = "suppp";
			navigator.geolocation.getCurrentPosition(showPosition, showError);
		}else{
			x.innerHTML = "not support";
		}
	}

	function showPosition(position){
		x.innerHTML = "latitude: " + position.coords.latitude;
		x.innerHTML += "<br/>";
		x.innerHTML += "longitude: " + position.coords.longitude;

		var locAPI = "http://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true";
		//x.innerHTML = locAPI;
		$.get({

			url: locAPI,
			success: function(data){
				console.log(data);
				x.innerHTML = data.results[0].address_components[4].long_name+", ";
				x.innerHTML += data.results[0].address_components[5].long_name+", ";
				x.innerHTML += data.results[0].address_components[6].long_name+", ";
				x.innerHTML += data.results[0].address_components[7].long_name;
				
			}

		});
	}

	function showError(error){
		switch(error.code){
			case error.PERMISSION_DENIED:
			x.innerHTML = "code: "+ error.code +" User don't want to share location";
			break;
			case error.POSITION_UNAVAILABLE:
			x.innerHTML = "code: "+ error.code +" User location data is not available";
			break;
			case error.TIMEOUT:
			x.innerHTML = "code: "+ error.code +" Tmeout !!";
			break;
			case error.UNKNOWN_ERROR:
			x.innerHTML = "code: "+ error.code +" There is something unknown errors";
			break;
		}
	}

/*
	0 = UNKNOWN_ERROR
	1 = PERMISSION_DENIED
	2 = POSITION_UNAVAILABLE
	3 = TIMEOUT
*/

</script>

</body>
</html>