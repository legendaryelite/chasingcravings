<!DOCTYPE html>
<!-- This page is designed to provide login functionality -->
<html lang="en">
<head>
	<?php include "headInfo.php";?>
</head>
<body>
	<?php 
		include "desktopheader.php";
		$nameErr = $pwdErr = $specialMessage = "";
		$username = $pwd = "";
		// If the page is loaded with a POST request
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			// Data validation for username and password
			if(empty($_POST['username'])){
				$nameErr = "Name is required.";
			}else{
				$username = $_POST['username'];
			}
			if(empty($_POST['pwd'])){
				$pwdErr = "Password is required.";
			}else{
				$pwd = $_POST['pwd'];
			}
			// If there are no errors in the fields, get the account information and verify password is correct.
			if($nameErr == "" && $pwdErr == ""){
				$userQuery = "SELECT * FROM useraccounts WHERE username LIKE '".$username."' AND pwd LIKE '".$pwd."'";
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
					$specialMessage = "Invalid username and/or password.";
				}
				// If the username and password are authenticated, load the session and redirect to the index page
				else{
					$row = mysqli_fetch_assoc($result);
					$_SESSION['userID'] = $row['userID'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['pwd'] = $row['pwd'];
					$_SESSION['acctType'] = $row['acctType'];
					$specialMessage = "Login Successful";
					echo "<script>window.location.replace(\"index.php\");</script>";
				}
			}
		}
	?>
	<div id="page-wrapper">
		<h1>Login</h1>
		<div class="form-wrapper">
			<!-- This generates the form for username and password -->
			<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table border=0>
				<div class="container">
					<tr>
						<td>
							<label><b>Username</b></label>
						</td>
						<td>
							<input type = "text" name ="username" required maxlength="20">
							<span class="error"><?php echo $nameErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Password</b></label>
						</td>
						<td>
							<input type = "password" name ="pwd" required maxlength = "50">
							<span class="error"><?php echo $pwdErr;?></span>
						</td>
					</tr>
				</div>
			</table>
			<div class="container">
				<button type ="submit"> Submit</button>
			</div>
			</form>
		<?php echo $specialMessage; ?>
		</div>
	</div>
</body>
</html>	
