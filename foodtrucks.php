<!DOCTYPE html>
<html>
<head>
	<?php include "headInfo.php"?>
	<?php include "desktopheader.php"?>
</head>

<body>
	<div id="page-wrapper">
			<?php
				include "dbcredentials.php";

				$connect=mysqli_connect($server, $user, $pw, $db);

				if( !$connect) 
				{
					die("ERROR: Cannot connect to database $db on server $server 
					using user name $user (".mysqli_connect_errno().
					", ".mysqli_connect_error().")");
				}
				// Generate the query to get all of the needed food truck data
				$userQuery = "SELECT pictureURL, truckID, truckName, (SELECT avg(rating) FROM comments WHERE trucks.truckID = comments.truckID) AS rating FROM trucks;";
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
				// Generate the html code to display food truck information
				else 
				{ 
					print("<h1>Food Trucks</h1>");
					//print("<div class=\"form-wrapper\">");
					print("<table border = \"1\">");
					print("<tr><th></th><th>Truck Name</th>
						<th>Rating</th></tr>");
					while ($row = mysqli_fetch_assoc($result))
					{
						print ("<tr><td><img src=".$row['pictureURL']."></td><td><a href=\"truck.php?truckID=".$row['truckID']."\">".$row['truckName']."</a></td><td>"
								.number_format($row['rating'], 2).
								"</td></tr>");
					}
					print("</table");
				}
				mysqli_close($connect);   // close the connection
			?>
		</div>
	</div>
</body>
</html>
