<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Chasing Cravings</title>
  <meta name="description" content="A locating website to help you keep up with your favorite food trucks!">
  <meta name="author" content="Chasing Cravings" />

  <link rel="stylesheet" href="css/navbar.css">
  <style>
      #map {
        height: 600px;
        width: 85%;
       }
  </style>
</head>
<body>
	<div id="nav-bar" role="complementary" class="border js-fullheight">
		<div class="nav-logo"></div>
			<nav id="main-menu" role="navigation">
				<ul class="nav-bar">
					<li id="logo" class="active"><a href="index.html"><img src=""></a></li>
					<li><a href="foodtrucks.html">Food Trucks</a></li>
					<li style="float:right"><a href="signin.html">Sign In/Create Account</a></li>
				</ul>
			</nav>
	</div>
	
	
	<div id="page-wrapper">	
		<div id="map"></div>
		<?php 
		$server = "localhost";
		$db = "chasingcravings";
		if(isset($_SESSION['username']) != null && isset($_SESSION['pwd']) != null){
			$user = $_SESSION['username'];
			$pw = $_SESSION['pwd'];
		}
		else{
			$user = "root";
			$pw = "";
		}

		$connect=mysqli_connect($server, $user, $pw, $db);

		if( !$connect) 
		{
			die("ERROR: Cannot connect to database $db on server $server 
			using user name $user (".mysqli_connect_errno().
			", ".mysqli_connect_error().")");
		}
		if(isset($_SESSION['favoritesOnly']) != null && isset($_SESSION['userID']) != null){
			$userQuery = "SELECT truckID, truckName, lastTruckLat, lastTruckLong FROM trucks, favorites WHERE favorites.truckID = trucks.truckID AND favorites.truckID = ".$_SESSION['userID'].";";
		}
		else{
			$userQuery = "SELECT truckID, truckName, lastTruckLat, lastTruckLong FROM trucks;";
		}
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
				echo "var uluru".$rownum." = {lat: ".number_format($row['lastTruckLat'], 5).", lng: ".number_format($row['lastTruckLong'], 5)."};
				";
				if($rownum == 0){
					echo "var map = new google.maps.Map(document.getElementById('map'), {
					  zoom: 4,
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
