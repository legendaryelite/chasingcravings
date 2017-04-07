<!DOCTYPE html>
<html>
<head>
	<link rel = "stylesheet" type="text/css" href="truckpage.css"/>
	<link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="css/bootstrap.min.css" rel="stylesheet">
<title>Chasing Cravings</title>
<style>
      #map {
        height: 300px;
        width: 25%;
       }
  </style>
</head>
<body>
	<?php 
		include "desktopheader.php";
		include "dbcredentials.php";
		// Use GET method from generated URL to capture the truckID
		$userQuery = "SELECT * FROM trucks WHERE truckID=".$_GET['truckID'];
		
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
		if (mysqli_num_rows($result) == 0) 
		{
			print("No records found with query ".$userQuery);
		}
		else 
		{ 
			// Get truck information for display
			$row = mysqli_fetch_assoc($result);
			$_SESSION['truckID'] = $row['truckID'];
			$truckName = $row['truckName'];
			$cuisine = $row['cuisine'];
			$hours = $row['hours'];
			$picURL = $row['pictureURL'];
			$truckURL = $row['truckURL'];
			$lastTruckLat = $row['lastTruckLat'];
			$lastTruckLong = $row['lastTruckLong'];
		}
		// If the user submitted a comment/rating
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			// Comment/Rating portion
			$userQuery = "SELECT * FROM comments WHERE userID=".$_SESSION['userID']." AND truckID=".$_SESSION['truckID'];
			$result = mysqli_query($connect, $userQuery);
			$alreadyCommented = false;
			if (!$result) 
			{
				die("Could not successfully run query ($userQuery) from $db: " .	
				mysqli_error($connect) );
			}	
			if (mysqli_num_rows($result) > 0) 
			{
				$alreadyCommented = true;
			}
			// If a comment/rating exists already for the user/truck pair, update it to the new one
			if($alreadyCommented){
				$userQuery = "UPDATE `comments` SET `rating`=".$_POST['rating'].",`cmnt`='".$_POST['comment']."' WHERE userID=".$_SESSION['userID']." AND truckID=".$_SESSION['truckID'];
			}
			// If the comment/rating does not exist, add it
			else{
				$userQuery = "INSERT INTO `comments`(`userID`, `truckID`, `rating`, `cmnt`) VALUES (".$_SESSION['userID'].", ".$_SESSION['truckID'].", ".$_POST['rating'].", '".$_POST['comment']."')";
			}
			$result = mysqli_query($connect, $userQuery);
			if (!$result) 
			{
				die("Could not successfully run query ($userQuery) from $db: " .	
				mysqli_error($connect) );
			}
			// Favorites
			$userQuery = "SELECT * FROM favorites WHERE userID=".$_SESSION['userID']." AND truckID=".$_SESSION['truckID'];
			$result = mysqli_query($connect, $userQuery);
			if(!$result)
			{
				die("Could not successfully run query ($userQuery) from $db: " .	
				mysqli_error($connect) );
			}
			$wasFavorite = mysqli_num_rows($result) > 0;
			$isFavorite = isset($_POST['favorite']) != null;
			if($wasFavorite && !$isFavorite){
				// delete
				$userQuery = "DELETE FROM favorites WHERE userID=".$_SESSION['userID']. " AND truckID=".$_SESSION['truckID'];
			}
			else if(!$wasFavorite && $isFavorite){
				// insert
				$userQuery = "INSERT INTO `favorites`(`userID`, `truckID`) VALUES (".$_SESSION['userID'].",".$_SESSION['truckID'].")";
			}
			$result = mysqli_query($connect, $userQuery);
			if(!$result){
				die("Could not successfully run query ($userQuery) from $db: " .	
				mysqli_error($connect) );
			}
		}
		mysqli_close($connect);
		
	?>
	<div id = "intro">
		<h1> <?php echo $truckName;?> </h1>
		<div id="map"></div>
		<?php
			// Display a map with the location of the individual truck
			echo "<script>
			function initMap() {
				var uluru = {lat: ".number_format($lastTruckLat, 5).", lng: ".number_format($lastTruckLong, 5)."};
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 12,
					center: uluru
				});
				var marker = new google.maps.Marker({
				  position: uluru,
				  map: map
				});	
			}
			</script>
			<script async defer
			  src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCCXuyY-DXEtsMn_evGMrhPFjEfWNYy1jo&callback=initMap\">
			</script>";
		?>
		<!-- Display truck information-->
		<table border=1>
			<tr>
				<td>Cuisine</td>
				<td><?php echo $cuisine;?></td>
			</tr>
			<tr>
				<td>Hours</td>
				<td><?php echo $hours;?></td>
			</tr>
			<tr>
				<td>Truck URL</td>
				<td><a href="<?php echo $truckURL;?>"><?php echo $truckURL;?></a></td>
			</tr>
			<tr>
				<td>Picture</td>
				<td><img src="<?php echo $picURL;?>"></td>
			</tr>
		</table>

		<br>
		<?php
			// Display any comments/ratings
			$connect=mysqli_connect($server, $user, $pw, $db);
			if( !$connect) 
			{
				die("ERROR: Cannot connect to database $db on server $server 
				using user name $user (".mysqli_connect_errno().
				", ".mysqli_connect_error().")");
			}
			$userQuery = "SELECT useraccounts.username AS username, comments.rating AS rating, comments.cmnt AS cmnt FROM comments, useraccounts WHERE comments.truckID=".$_SESSION['truckID']." AND useraccounts.userID = comments.userID";
			$result = mysqli_query($connect, $userQuery);
			mysqli_close($connect);
			if (!$result) 
			{
				die("Could not successfully run query ($userQuery) from $db: " .	
				mysqli_error($connect) );
			}	
			if (mysqli_num_rows($result) == 0) 
			{
				echo "<p>No comments yet.</p>";
			}
			else 
			{ 
				echo "<table border=1>
					<tr>
						<td><label><b>User</b></label></td>
						<td><label><b>Rating</b></label></td>
						<td><label><b>Comment</b></label></td>
					</tr>
					";
				while($row = mysqli_fetch_assoc($result)){
					echo "<tr>
						<td>".$row['username']."</td>
						<td><center>".$row['rating']."</center></td>
						<td>".$row['cmnt']."</td>
					</tr>";
				}	
				echo "</table>
				";
			}
			// If the user is logged in, allow them to leave a comment/rating
			if(isset($_SESSION['userID']) != null){
				// If the user has already commented, fill in the previous comments/rating
				$connect=mysqli_connect($server, $user, $pw, $db);
				$userQuery = "SELECT rating, cmnt FROM comments WHERE userid=".$_SESSION['userID']." AND truckID=".$_SESSION['truckID'];
				$result = mysqli_query($connect, $userQuery);
				if (!$result) 
				{
					die("Could not successfully run query ($userQuery) from $db: " .	
					mysqli_error($connect) );
				}	
				$prevComment = "";
				$prevRating = "";
				$prevFavorite = "";
				if (mysqli_num_rows($result) > 0) 
				{
					$row = mysqli_fetch_assoc($result);
					$prevComment = $row['cmnt'];
					$prevRating = $row['rating'];
					// If it was favorited by the user
					$userQuery = "SELECT favoriteID FROM favorites WHERE userid=".$_SESSION['userID']." AND truckID=".$_SESSION['truckID'];
					$result = mysqli_query($connect, $userQuery);
					if (!$result) 
					{
						die("Could not successfully run query ($userQuery) from $db: " .	
						mysqli_error($connect) );
					}	
					if(mysqli_num_rows($result) > 0)
					{
						$prevFavorite = "checked=\"checked\"";
					}
				}
				mysqli_close($connect);
				echo "<div class=\"form-group\">
					<br>
					<form action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."?truckID=".$_SESSION['truckID']."\" method=\"post\">
						<table>
							<tr>
								<td>Rating</td>
								<td>
									<select name=\"rating\">
										";
										if($prevRating == 5){echo "<option value=5 selected>5</option>";}
										else{echo "<option value=5>5</option>";}
										if($prevRating == 4){echo "<option value=4 selected>4</option>";}
										else{echo "<option value=4>4</option>";}
										if($prevRating == 3){echo "<option value=3 selected>3</option>";}
										else{echo "<option value=3>3</option>";}
										if($prevRating == 2){echo "<option value=2 selected>2</option>";}
										else{echo "<option value=2>2</option>";}
										if($prevRating == 1){echo "<option value=1 selected>1</option>";}
										else{echo "<option value=1>1</option>";}
									echo"</select>
								</td>
								<td>
									<input type=\"checkbox\" name=\"favorite\" value=\"favorite\" ".$prevFavorite.">Favorite this truck<br>
								</td>
							</tr>
							<tr>
								<td colspan=\"2\">Comment: </td>
							</tr>
							<tr>
								<td colspan=\"5\"><textarea name=\"comment\" rows=\"10\" cols=\"50\">".$prevComment."</textarea></td>
							</tr>
							<tr>
								<td colspan=\"2\"><button type =\"submit\">Submit</button></td>
							</tr>
						</table>
					</form>
				</div>";
				
			}
		?>
	</div>
	<!-- I've commented this out since the database doesn't support a twitter entry yet
	<div>
		<a class="twitter-timeline" data-width="300" data-height="600" href="https://twitter.com/FoxNews">Tweets by FoxNews</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div> -->


  <!--Need Comment Box
   Need GPS Locator
   Need Twitter Live Feed
   Need Updatable Menu
   Status Box/Wall -->
</body>
</html>
