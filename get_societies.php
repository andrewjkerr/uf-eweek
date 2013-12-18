<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Calls database and returns JSON with societies in alphabetical order.
		USAGE: http://localhost/~andrewjkerr/eweek/get_societies.php will return all societies in alphabetical order in a JSON format.
	*/
	require('mysql_connect.php');
	$result = mysqli_query($link, "SELECT * FROM societies ORDER BY name ASC"); 
	$json = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($json);
?>