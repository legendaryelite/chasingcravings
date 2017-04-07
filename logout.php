<!DOCTYPE HTML>
<?php
	// This file kills the session (logging the user out) and redirects the browser to the index page
	session_start();
	session_unset();
	session_destroy();
	echo "<script>window.location.replace(\"index.php\");</script>";
?>
