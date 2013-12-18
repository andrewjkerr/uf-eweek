<?php
	session_start();
	echo $_SESSION['uid'] . ": " . $_SESSION['name'] . ": " . $_SESSION['adminlevel'] . ": " . $_SESSION['eventadmin'] . ": " . $_SESSION['is_society'];
?>