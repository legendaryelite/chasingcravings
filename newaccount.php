<!DOCTYPE  html>
<html>
	<head>
		<title> Chasing Creavings</title>
	</head>
	<body>
		<?php
			$newName = $newEmail = $newPwd = $confPwd = "";
			$nameErr = $emailErr = $pwdErr = $confErr = "";
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST['username'])){
					$nameErr = "Name is required.";
				}else{
					$newName = test_input($_POST['username']);
					if (!preg_match("/^[a-zA-Z0-9]*$/",$newName)) {
						$nameErr = "Only letters and numbers allowed."; 
					}
				}
				if(empty($_POST['email'])){
					$emailErr = "Email is required.";
				}else{
					$newEmail = test_input($_POST['email']);
					if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
						$emailErr = "Invalid email format"; 
					}
				}
				if(empty($_POST['pwd'])){
					$pwdErr = "Password is required.";
				}else{
					$newPwd = test_input($_POST['pwd']);
				}
				if(empty($_POST['confirmpassword'])){
					$confErr = "Confirm Password is required.";
				}else{
					$confPwd = test_input($_POST['confirmpassword']);
					if ($confPwd != $newPwd){
						$confErr = "Passwords do not match.";
					}
				}
			}
			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
		?>
		<div>
			<h1> Create User Account</h1>
			<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table border=0>
				<div class="container">
					<tr>
						<td>
							<label><b>Username</b></label>
						</td>
						<td>
							<input type = "text" value="<?php echo $newName;?>" name ="username" required>
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
							<input type = "email" value="<?php echo $newEmail;?>" name ="email" required>
							<span class="error"><?php echo $emailErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Password</b></label>
						</td>
						<td>
							<input type = "password" value="<?php echo $newPwd;?>" name ="pwd" required>
							<span class="error"><?php echo $pwdErr;?></span>
						</td>
					</tr>
				</div>
				<div class="container">
					<tr>
						<td>
							<label><b>Confirm Password</b></label>
						</td>
						<td>
							<input type = "password" value="<?php echo $confPwd;?>" name ="confirmpassword" required>
							<span class="error"><?php echo $confErr;?></span>
						</td>
					</tr>
				</div>
			</table>
			<div class="container">
				<button type ="submit"> Submit</button>
			</div>
			</form>
		</div>
	</body>
</html>
