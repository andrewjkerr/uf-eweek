<?php
	require('mysql_connect.php');
	$eventid = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
	if($eventid == 'all'){
		$result = mysqli_query($link, "SELECT * FROM events"); 
		$json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
		echo json_encode($json);
	}
	else{
		$result = mysqli_query($link, "SELECT * FROM events WHERE shortname = '$eventid'");
		if(mysqli_num_rows($result) == 1){
			$json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
			echo json_encode($json);
		}
		else{
			echo "Error!!!";
		}
	}
?>