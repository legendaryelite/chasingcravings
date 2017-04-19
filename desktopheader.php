<?php echo '<link rel="stylesheet" type="text/css" href="navbar.css">'; ?>
<?php echo '<link rel="stylesheet" type="text/css" href="stylesheet.css">'; ?>

<?php
	// This php file generates the header based on whether a login session has been started or not.
	session_start();
	echo "<div id=\"nav-bar\" role=\"complementary\" class=\"border js-fullheight\">
		<div class=\"nav-logo\"></div>
			<nav id=\"main-menu\" role=\"navigation\">
				<ul class=\"nav-bar\">
					<li id=\"logo\" class=\"active\"><a href=\"index.php\">Index<img src=\"\"></a></li>
					<li><a href=\"foodtrucks.php\">Food Trucks</a></li>";
	// If a session is not active, show sign in/ create account
	if(isset($_SESSION['username']) == null){
		echo "				<li><a href=\"login.php\">Sign In</a></li>
							<li><a href=\"newaccount.php\">Create Account</a></li>";
	}
	// Otherwise, show username and account link as well as logout option.
	else{
		echo "				<li><a href=\"myaccount.php\">Welcome, ".$_SESSION['username']."</a></li>
							<ul><li><a href=\"logout.php\">Logout</a>";
	}		
	echo "			</ul>
			</nav>
	</div>
	";
?>
