<!DOCTYPE html>
<!--	Author: Chris Olsson
		Date:	March 25, 2017
		File:	foodtrucks.php
		Purpose: Displays the trucks that are contained in the database
-->

<html>
<head>
	<title>Food Truck</title>
	<link rel ="stylesheet" type="text/css" href="sample.css"  />
</head>

<body>
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
$userQuery = "SELECT truckID, truckName, (SELECT avg(rating) FROM comments WHERE trucks.truckID = comments.truckID) AS rating FROM trucks;";
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
	print("<h1>Food Trucks</h1>");

	print("<table border = \"1\">");
	print("<tr><th>truckID</th><th>Truck Name</th>
		 <th>Rating</th></tr>");

	while ($row = mysqli_fetch_assoc($result))
	{
		print ("<tr><td>".$row['truckID']."</td><td>".$row['truckName']."</td><td>"
				.number_format($row['rating'], 2).
				"</td></tr>");
	}

	print("</table");
}

mysqli_close($connect);   // close the connection
 
?>
</body>
</html>
