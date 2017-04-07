<!DOCTYPE html>
<!-- This page shows information about the user's account and allows editing of that information-->
<html lang="en">
	<head>
		<?php include "headInfo.php";?>
	</head>
	<body>
		<?php 
			include "desktopheader.php";
			include "dbcredentials.php";
			$connect=mysqli_connect($server, $user, $pw, $db);
			if(isset($_SESSION['userID']) != null){
				$newTruckName = $newCuisine = $newHours = $newPictureURL = $newTruckURL = $newServesBreakfast = $newServesLunch = $newServesDinner = $newTruckLat = $newTruckLong = "";
				$truckNameErr = $cuisineErr = $hoursErr = $pictureURLErr = $truckURLErr = $servesBreakfastErr = $servesLunchErr = $servesDinnerErr = $truckLatErr = $truckLongErr = $specialMessage = "";
				$truckExists = false;
				$changeMade = false;
				if( !$connect) 
				{
					die("ERROR: Cannot connect to database $db on server $server 
					using user name $user (".mysqli_connect_errno().
					", ".mysqli_connect_error().")");
				}
				else{
					$userQuery = "SELECT * FROM trucks WHERE userID=".$_SESSION['userID'];
					$result = mysqli_query($connect, $userQuery);
					if(!$result){
						die("Could not successfully run query ($userQuery) from $db: " .	
						mysqli_error($connect) );
					}
					else{
						if(mysqli_num_rows($result) > 0){
							$row = mysqli_fetch_assoc($result);
							$newTruckName = $row['truckName'];
							$newCuisine = $row['cuisine'];
							$newHours = $row['hours'];
							$newPictureURL = $row['pictureURL'];
							$newTruckURL = $row['truckURL'];
							if($row['servesBreakfast'] == 1){ $newServesBreakfast = "checked";}
							if($row['servesLunch'] == 1){$newServesLunch = "checked";}
							if($row['servesDinner']==1){$newServesDinner = "checked";}
							$newTruckLat = $row['lastTruckLat'];
							$newTruckLong = $row['lastTruckLong'];
							$truckExists = true;
						}	
					}
					if($_SERVER['REQUEST_METHOD'] == "POST"){
						// Validate the new data
						if($_POST['truckName'] != $newTruckName){
							$newTruckName = validate_data($_POST['truckName']);
							$changeMade = true;
						}
						if($_POST['cuisine'] != $newCuisine){
							$newCuisine = validate_data($_POST['cuisine']);
							$changeMade = true;
						}
						if($_POST['hours'] != $newHours){
							$newHours = validate_data($_POST['hours']);
							$changeMade = true;
						}
						if($_POST['pictureURL'] != $newPictureURL){
							$newPictureURL = validate_data($_POST['pictureURL']);
							$changeMade = true;
						}
						if($_POST['truckURL'] != $newTruckURL){
							$newTruckURL = validate_data($_POST['truckURL']);
							$changeMade = true;
						}
						if(isset($_POST['servesBreakfast']) == null && $newServesBreakfast == "checked"){
							$newServesBreakfast = "";
							$changeMade = true;
						}
						else if(isset($_POST['servesBreakfast']) != null && $newServesBreakfast == ""){
							$newServesBreakfast = "checked";
							$changeMade = true;
						}
						if(isset($_POST['servesLunch']) == null && $newServesLunch == "checked"){
							$newServesLunch = "";
							$changeMade = true;
						}
						else if(isset($_POST['servesLunch']) != null && $newServesLunch == ""){
							$newServesLunch = "checked";
							$changeMade = true;
						}
						if(isset($_POST['servesDinner']) == null && $newServesDinner == "checked"){
							$newServesDinner = "";
							$changeMade = true;
						}
						else if(isset($_POST['servesDinner']) != null && $newServesDinner == ""){
							$newServesDinner = "checked";
							$changeMade = true;
						}
						if($_POST['truckLat'] != $newTruckLat){
							$newTruckLat = validate_data($_POST['truckLat']);
							$changeMade = true;
						}
						if($_POST['truckLong'] != $newTruckLong){
							$newTruckLong = validate_data($_POST['truckLong']);
							$changeMade = true;
						}
						if($truckExists){
							if($changeMade && $truckNameErr == "" && $cuisineErr == "" && $hoursErr == "" && $pictureURLErr == "" && $truckURLErr == "" && $servesBreakfastErr == "" && $servesLunchErr == "" 
							&& $servesDinnerErr == "" && $truckLatErr == "" && $truckLongErr == ""){
								$userQuery = "UPDATE `trucks` SET `truckName`=\"".$newTruckName."\",`cuisine`=\"".$newCuisine."\",`hours`=\"".$newHours."\",`pictureURL`=\"".$newPictureURL."\",`truckURL`=\"".$newTruckURL."\",`servesBreakfast`=".($newServesBreakfast=="checked" ? 1 : 0).",`servesLunch`=".($newServesLunch=="checked" ? 1 : 0).",`servesDinner`=".($newServesDinner=="checked" ? 1 : 0).",`lastTruckLat`=".$newTruckLat.",`lastTruckLong`=".$newTruckLong." WHERE userID=".$_SESSION['userID'];
								$result = mysqli_query($connect, $userQuery);
								$specialMessage = "Truck updated!";
							}
						}
						else{
							if($truckNameErr == "" && $cuisineErr == "" && $hoursErr == "" && $pictureURLErr == "" && $truckURLErr == "" && $servesBreakfastErr == "" && $servesLunchErr == "" 
							&& $servesDinnerErr == "" && $truckLatErr == "" && $truckLongErr == ""){
								$userQuery = "INSERT INTO `trucks`(`truckName`, `userID`, `cuisine`, `hours`, `pictureURL`, `truckURL`, `servesBreakfast`, `servesLunch`, `servesDinner`, `lastTruckLat`, `lastTruckLong`) VALUES (\"".$newTruckName."\",".$_SESSION['userID'].",\"".$newCuisine."\",\"".$newHours."\",\"".$newPictureURL."\",\"".$newTruckURL."\",".($newServesBreakfast=="checked" ? 1 : 0).",".($newServesLunch=="checked" ? 1 : 0).",".($newServesDinner=="checked" ? 1 : 0).",".$newTruckLat.",".$newTruckLong.")";
								$result = mysqli_query($connect, $userQuery);
								$specialMessage = "Truck added!";
							}
						}
					}
				}
			}
			else{
				echo "<script>window.location.replace(\"login.php\");</script>";
			}
			
			mysqli_close($connect);
			// This fuction validates the entered data
			function validate_data($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
		?>
		<h3>Truck Information</h3>
		<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table border=0>
				<div class="container">
					<tr>
						<td>
							<label><b>Truck Name</b></label>
						</td>
						<td>
							<input type = "text" value="<?php echo $newTruckName;?>" name ="truckName" maxlength="50">
							<span class="error"><?php echo $truckNameErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Cuisine</b></label>
						</td>
						<td>
							<input type="text" value="<?php echo $newCuisine;?>" name="cuisine" maxlength="50">
							<span class="error"><?php echo $cuisineErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Hours</b></label>
						</td>
						<td>
							<input type="text" value="<?php echo $newHours;?>" name="hours" maxlength="100">
							<span class="error"><?php echo $hoursErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Truck URL</b></label>
						</td>
						<td>
							<input type="text" value="<?php echo $newTruckURL;?>" name="truckURL" maxlength="100">
							<span class="error"><?php echo $truckURLErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Picture URL</b></label>
						</td>
						<td>
							<input type="text" value="<?php echo $newPictureURL;?>" name="pictureURL" maxlength="100">
							<span class="error"><?php echo $cuisineErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Serves Breakfast</b></label>
						</td>
						<td>
							<input type="checkbox" value="servesBreakfast" name="servesBreakfast" <?php echo $newServesBreakfast;?>>
							<span class="error"><?php echo $servesBreakfastErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Serves Lunch</b></label>
						</td>
						<td>
							<input type="checkbox" value="servesLunch" name="servesLunch" <?php echo $newServesLunch;?>>
							<span class="error"><?php echo $servesLunchErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Serves Dinner</b></label>
						</td>
						<td>
							<input type="checkbox" value="servesDinner" name="servesDinner" <?php echo $newServesDinner;?>>
							<span class="error"><?php echo $servesDinnerErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Truck Latitude</b></label>
						</td>
						<td>
							<input type="number" value="<?php if($truckExists){echo number_format($newTruckLat, 5);}?>" name="truckLat" step="any">
							<span class="error"><?php echo $truckLatErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Truck Longitude</b></label>
						</td>
						<td>
							<input type="number" value="<?php if($truckExists){echo number_format($newTruckLong, 5);}?>" name="truckLong" step="any">
							<span class="error"><?php echo $truckLongErr;?></span>
						</td>
					</tr>
				</div>
			</table>
			<div class="container">
				<button type ="submit">Save Changes</button>
			</div>
		</form>
		<br><p><?php echo $specialMessage;?></p>
		<br><p><a href="myaccount.php">Return to Account</a></p>
	</body>
</html>	
