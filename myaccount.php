<!DOCTYPE html>
<!-- This page shows information about the user's account and allows editing of that information-->
<html lang="en">
	<head>
		<?php include "headInfo.php";?>
	</head>
	<body>
			<?php 
				include "desktopheader.php";
				$newName = $newEmail = $newPwd = $confPwd = $newAcctType = "";
				$nameErr = $emailErr = $pwdErr = $confErr = $typeErr = $specialMessage = "";
				
				include "dbcredentials.php";
				
				$connect=mysqli_connect($server, $user, $pw, $db);
				if( !$connect) 
				{
					die("ERROR: Cannot connect to database $db on server $server 
					using user name $user (".mysqli_connect_errno().
					", ".mysqli_connect_error().")");
				}
				else{
					// Makes sure the user is logged in
					// This page should not be accessible normally without being logged in
					if(isset($_SESSION['userID']) != null){
						$userQuery = "SELECT * FROM useraccounts WHERE userID = ".$_SESSION['userID'].";";
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
							// Get account information for display
							$row = mysqli_fetch_assoc($result);
							$newName = $row['username'];
							$newEmail = $row['email'];
							$newPwd = $row['pwd'];
							$newAcctType = $row['acctType'];
						}
						
					}
					else{
						// If the user got here without being logged in, send them to the log in page
						echo "<script>window.location.replace(\"login.php\");</script>";
					}
					// If the user submits changes
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						// Validate the new data
						$changeMade = false;
						if($_POST['username'] != $newName){
							$newName = test_input($_POST['username']);
							$changeMade = true;
							if (!preg_match("/^[a-zA-Z0-9]*$/",$newName)) {
								$nameErr = "Only letters and numbers allowed."; 
							}
						}
						if($_POST['email'] != $newEmail){
							$newEmail = test_input($_POST['email']);
							$changeMade = true;
							if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
								$emailErr = "Invalid email format"; 
							}
						}
						if(!empty($_POST['pwd'])) {
							if(!empty($_POST['oldPwd'])){
								if($newPwd != $_POST['oldPwd']){
									$pwdErr = "Old password is incorrect.";
								} 
								else{
									if($_POST['pwd'] == $_POST['confirmpassword']){
										$newPwd = test_input($_POST['pwd']);
										$changeMade = true;
									}
									else{
										$confErr = "Passwords do not match.";
									}
								}			
							}
							else{
								$pwdErr = "Old Password is required to change passwords.";
							}
						}
						if($_POST['acctType'] != $newAcctType){
							$newAcctType = test_input($_POST['acctType']);
							$changeMade = true;
						}
						// and update the database
						if($changeMade == true && $nameErr == "" && $emailErr == "" && $pwdErr == "" && $confErr == ""){
							$userQuery = "UPDATE `useraccounts` SET `userID`=".$_SESSION['userID'].",`username`='".$newName."',`email`='".$newEmail."',`pwd`='".$newPwd."',`acctType`='".$newAcctType."' WHERE userID=".$_SESSION['userID'];
							$result = mysqli_query($connect, $userQuery);
						
							if (!$result) 
							{
								die("Could not successfully run query ($userQuery) from $db: " .	
								mysqli_error($connect) );
							}	
							$specialMessage = "Account updated successfully!";
						}
					}
					mysqli_close($connect);
				}
				// This fuction validates the entered data
				function test_input($data){
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}
				
			?>
			<div id="page-wrapper">
			<aside id="nav-aside" role="complementary">
				<nav id="nav-menu" role="navigation">
					<ul>
						<li class="active"><a href="myaccount.php">Manage Account</a></li>
						<li><a href="favorites.php">Favorites</a></li>
					</ul>
				</nav>
			</aside>
			<h1>Your Account Information</h1>
			<div class="form-wrapper-account">
				<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<table border=0>
						<div class="container">
							<tr>
								<td>
									<label><b>Username</b></label>
								</td>
								<td>
									<input type = "text" value="<?php echo $newName;?>" name ="username" maxlength="20">
									<span class="error"><?php echo $nameErr;?></span>
								</td>
							</tr>
						</div>
						<div class="container">
							<tr>
								<td>
									<label><b>Email</b></label>
								</td>
								<td>
									<input type = "email" value="<?php echo $newEmail;?>" name ="email" maxlength="50">
									<span class="error"><?php echo $emailErr;?></span>
								</td>
							</tr>
						</div>
						<div class="container">
							<tr>
								<td>
									<label><b>Old Password</b></label>
								</td>
								<td>
									<input type = "password" name ="oldPwd" maxlength = "50">
									<span class="error"><?php echo $pwdErr;?></span>							
								</td>
							</tr>
						</div>
						<div class="container">
							<tr>
								<td>
									<label><b>New Password</b></label>
								</td>
								<td>
									<input type = "password" name ="pwd" maxlength = "50">
								</td>
							</tr>
						</div>
						<div class="container">
							<tr>
								<td>
									<label><b>Confirm Password</b></label>
								</td>
								<td>
									<input type = "password" name ="confirmpassword" maxlength="50">
									<span class="error"><?php echo $confErr;?></span>
								</td>
							</tr>
						</div>
						<div class="container">
							<tr>
								<td>
									<label><b>Account Type</b></label>
								</td>
								<td>
									<input type="radio" name="acctType" value="user" <?php if (isset($newAcctType) && $newAcctType == "user") echo "checked";?>>Normal User
									<input type="radio" name="acctType" value="truck" <?php if (isset($newAcctType) && $newAcctType == "truck") echo "checked";?>>Food Truck
									<span class="error"><?php echo $typeErr;?></span>
								</td>
							</tr>
						</div>
					</table>
				</div>
					<div class="container">
						<button type ="submit">Save Changes</button>
					</div>
				</form>
				<?php 
					echo $specialMessage."
					";
					if($newAcctType == "truck"){
						echo "<br><p><a href=\"truckaccount.php\">Go to Truck Account</a></p>";
					}
				?>
			</div>
    </div>
	</body>
</html>	

