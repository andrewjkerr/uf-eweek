<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Processes registration.
		USAGE: Use as a form action!
		TO-DO:
			- Make it use template
			- Add password reset option
			- Add societies to registration
	*/
	include('mysql_connect.php');
?>
<html>
<head>
	<title>Registration Processing</title>
</head>
<body>
	<h1>Processing registration...</h1>
	<?php
		$checkQuery = mysqli_prepare($link, "SELECT email FROM users WHERE email = ? or name = ?");
		$checkQuery->bind_param("ss", $pEmail, $pName);
		$pEmail = $_POST['email'];
		$pName = $_POST['name'];
		$checkQuery->execute();
		$checkQuery->store_result();
		if($checkQuery->num_rows() == 1){
			print("You have already registered! If you forgot your password, please contact the Technology Director to reset your password.");
		}
		else{
			$query = mysqli_prepare($link, "INSERT INTO users (id, name, email, password, adminlevel, eventadmin, is_society, soc1, soc2, soc3) VALUES (NULL, ?, ?, ?, '0', '0', '0', ?, ?, ?)");
			$query->bind_param("ssssss", $pName, $pEmail, $pHash, $pSec1, $pSec2, $pSec3);
			$pName = $_POST['name'];
			$pEmail = $_POST['email'];
			$pHash = $_POST['hashed_pass'];
			$pSec1 = $_POST['sid1'];
			$pSec2 = $_POST['sid2'];
			$pSec3 = $_POST['sid3'];
			$query->execute();
			print("Success!");
		}
	?>
</body>
</html>