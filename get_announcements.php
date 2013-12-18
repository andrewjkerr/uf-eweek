<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Calls database and returns JSON with announcements in descending order..
		USAGE: http://localhost/~andrewjkerr/eweek/get_announcements.php will return all announcements in descending order in a JSON format.
	*/
	require('mysql_connect.php');
	$result = mysqli_query($link, "SELECT * FROM announcements ORDER BY id DESC"); 
	$json = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($json);
?>