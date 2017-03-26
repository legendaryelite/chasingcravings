<!DOCTYPE html>
<html>
  <head>
    <style>
      #map {
        height: 400px;
        width: 100%;
       }
    </style>
  </head>
  <body>
    <h3>Chasing Cravings</h3>
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
		print("<script>");
      		print("function initMap() {");
		$rownum = 0;
		while ($row = mysqli_fetch_assoc($result))
		{
			print("var uluru".rownum." = {lat: ".number_format($row['lastTruckLat'], 3).", lng: ".number_format($row['lastTruckLong'], 3)."};");
        		print("var map".rownum." = new google.maps.Map(document.getElementById(\'map\'), {");
          		print("zoom: 4,");
          		print("center: uluru");
        		print("});");
        		print("var marker".rownum." = new google.maps.Marker({");
          		print("position: uluru,");
          		print("map: map");
        		print("});");
			$rownum++;
		}
	}
	mysqli_close($connect);   // close the connection
	print("}");
    	print("</script>");
   	print("<script async ");
	print("  defer src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCCXuyY-DXEtsMn_evGMrhPFjEfWNYy1jo&callback=initMap\">");
    	print("</script>");
	?>
  </body>
</html>
