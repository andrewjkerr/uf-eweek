<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Connects to database.
		USAGE: Include in php files and use $link!
	*/
	// Create connection
	$link=mysqli_connect("url","user","pass","dbname");

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>