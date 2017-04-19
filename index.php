<!DOCTYPE html>

	<!-- This is the primary index page.
	Contents include a Google Map with locations of food trucks marked-->

<html lang="en">
<head>
	<?php include "headInfo.php";?>
  <style> 
      #map {
        height: 700px;
        width: 85%;
		display: block;
		margin: auto;

       }
  </style>
</head>
<body>
	<?php include "desktopheader.php";?>
	
	<div id="page-wrapper">	
		<div id="map"></div>
		<?php 
			// If the session calls for favorites only, set query to only favorited items.  Otherwise, get all trucks
			if(isset($_SESSION['favoritesOnly']) != null && isset($_SESSION['userID']) != null){
				$userQuery = "SELECT truckID, truckName, lastTruckLat, lastTruckLong FROM trucks, favorites WHERE favorites.truckID = trucks.truckID AND favorites.truckID = ".$_SESSION['userID'].";";
			}
			else{
				$userQuery = "SELECT truckID, truckName, lastTruckLat, lastTruckLong FROM trucks;";
			}
			// Connect to database and run query
			include "dbcredentials.php";
			$connect=mysqli_connect($server, $user, $pw, $db);
			if( !$connect) 
			{
				die("ERROR: Cannot connect to database $db on server $server 
				using user name $user (".mysqli_connect_errno().
				", ".mysqli_connect_error().")");
			}
			$result = mysqli_query($connect, $userQuery);
			if (!$result) 
			{
				die("Could not successfully run query ($userQuery) from $db: " .	
				mysqli_error($connect) );
			}	
			mysqli_close($connect);
		
			if (mysqli_num_rows($result) == 0) 
			{
				print("No records found with query ".$userQuery);
			}
			else 
			{ 
				// This code generates the Javascript necessary to display the Google Map
				// It will also generate a new marker for each location of a food truck
				echo "<script>
				function initMap() {
					";
				$rownum = 0; 
				while($row = mysqli_fetch_assoc($result))
				{
					echo "var uluru".$rownum." = {lat: ".number_format($row['lastTruckLat'], 5).", lng: ".number_format($row['lastTruckLong'], 5)."};
					";
					if($rownum == 0){
						echo "var map = new google.maps.Map(document.getElementById('map'), {
						zoom: 12,
						center: uluru".$rownum."
						});
						";
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
		<footer id="footer">
			&copy; 2017 All Rights Reserved
		</footer>
	</div>
</body>
</html>
