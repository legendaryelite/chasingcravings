<!DOCTYPE HTML>
<html>
	<head>
		<?php include "headInfo.php";?>
	</head>
	<body>
		<?php
			include "desktopheader.php";
			include "dbcredentials.php";
			$connect=mysqli_connect($server, $user, $pw, $db);
			if( !$connect) 
			{
				die("ERROR: Cannot connect to database $db on server $server 
				using user name $user (".mysqli_connect_errno().
				", ".mysqli_connect_error().")");
			}
			// If the user is logged in...
			if(isset($_SESSION['userID']) != null){
				if($_GET['remove'] != null){
					$userQuery = "DELETE FROM favorites WHERE userID=".$_SESSION['userID']." AND truckID=".$_GET['remove'];
					$result = mysqli_query($connect, $userQuery);
				}
				$userQuery = "SELECT trucks.truckID AS truckID, trucks.pictureURL AS picURL, trucks.truckName AS truckName FROM favorites, trucks WHERE trucks.truckID = favorites.truckID AND favorites.userID =".$_SESSION['userID'];
				$result = mysqli_query($connect, $userQuery);
				if (!$result) 
				{
					die("Could not successfully run query ($userQuery) from $db: " .	
					mysqli_error($connect) );
				}
				if (mysqli_num_rows($result) == 0) 
				{
					echo "No favorites yet.
					";
				}
				// Generate the html code to display information
				else 
				{ 
					echo "<h1Favorites</h1>
					<table border = \"1\">
					<tr>
						<th></th>
						<th>Truck Name</th>
						<th></th>
					</tr>";
					while ($row = mysqli_fetch_assoc($result))
					{
						echo "<tr>
							<td>
								<img src=\"".$row['picURL']."\">
							</td>
							<td>
								<a href=\"truck.php?truckID=".$row['truckID']."\">".$row['truckName']."</a>
							</td>
							<td>
								<a href=\"favorites.php?remove=".$row['truckID']."\">X</a>
							</td>
						</tr>
						";
					}
					echo "</table>";
				}
				
				mysqli_close($connect);   // close the connection
			}
			else {
				// If the user got here without being logged in, send them to the log in page
				echo "<script>window.location.replace(\"login.php\");</script>";
			}
		?>
		<a href="myaccount.php">Return to Account</a>
	</body>
</html>

