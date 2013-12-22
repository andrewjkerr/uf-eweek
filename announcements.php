<?php
	session_start();
	if($_SESSION['adminlevel'] == 2 || $_SESSION['adminlevel'] == 3 || $_SESSION['adminlevel'] == 4 || $_SESSION['adminlevel'] == 5){
		echo 'Can you see me?';
	}
	else{
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=auth_error.php">';
	}
?>