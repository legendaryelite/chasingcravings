<!DOCTYPE html>
<html>
  <head>
    <style>
      #map {
        height: 600px;
        width: 85%;
       }
    </style>
  </head>
  <body>
    <h3>My Google Maps Demo</h3>
    <div id="map"></div>
	<?php 
	$server = "localhost";
	$user = "root";
	$pw = "";
	$db = "chasingcravings";

	$connect=mysqli_connect($server, $user, $pw, $db);

	if( !$connect) 
	{
		die("ERROR: Cannot connect to database $db on server $server 
		using user name $user (".mysqli_connect_errno().
		", ".mysqli_connect_error().")");
	}
	$userQuery = "SELECT truckID, truckName, lastTruckLat, lastTruckLong FROM trucks;";
	$result = mysqli_query($connect, $userQuery);
	if (!$result) 
	{
		die("Could not successfully run query ($userQuery) from $db: " .	
		mysqli_error($connect) );
	}	

	if (mysqli_num_rows($result) == 0) 
	{
		print("No records found with query $userQuery");
	}
	else 
	{ 
		echo "<script>
		function initMap() {
			";
		$rownum = 0; 
		while($row = mysqli_fetch_assoc($result))
		{
			echo "var uluru".$rownum." = {lat: ".number_format($row['lastTruckLat'], 3).", lng: ".number_format($row['lastTruckLong'], 3)."};";
			if($rownum == 0){
				echo "var map = new google.maps.Map(document.getElementById('map'), {
				  zoom: 4,
				  center: uluru".$rownum."
				});";
			}
			echo "var marker".$rownum." = new google.maps.Marker({
			  position: uluru".$rownum.",
			  map: map
			});
			";
			$rownum++;
		}
		echo "}
		</script>
		<script async defer
		  src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCCXuyY-DXEtsMn_evGMrhPFjEfWNYy1jo&callback=initMap\">
		</script>";
	}
	?>
  </body>
</html>
