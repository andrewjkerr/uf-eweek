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
	session_start();
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
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=registration.php#error2">';
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
			print("Success! Now logging you in...");
			$loginQuery = mysqli_prepare($link, "SELECT id, name, adminlevel, eventadmin FROM users WHERE email = ?");
			$loginQuery->bind_param("s", $pEmail);
			$pEmail = $_POST['email'];
			$loginQuery->execute();
			$loginQuery->store_result();
			$loginQuery->bind_result($uid, $name, $adminlevel, $eventadmin);
			$loginQuery->fetch();
			$_SESSION['uid'] = $uid;
			$_SESSION['name'] = $name;
			$_SESSION['adminlevel'] = $adminlevel;
			$_SESSION['eventadmin'] = $eventadmin;
			$_SESSION['is_society'] = 0;
			echo '<p>Login successful!</p>';
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=tests/test_login.php">';
		}
	?>
</body>
</html>