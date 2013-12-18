<?php
	require('mysql_connect.php');
	$result = mysqli_query($link, "SELECT * FROM announcements ORDER BY id DESC"); 
	$json = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($json);
?>