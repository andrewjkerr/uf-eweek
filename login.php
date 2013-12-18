<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Processes logins.
		USAGE: Use as a form action!
	*/
	include('mysql_connect.php');
	session_start();
?>
<html>
<head>
	<title>Login Processing</title>
</head>
<body>
	<h1>Processing login...</h1>
	<?php
		$checkQuery = mysqli_prepare($link, "SELECT id, name, email, password FROM users WHERE email = ? AND password = ?");
		$checkQuery->bind_param("ss", $pEmail, $pPassword);
		$pEmail = $_POST['email'];
		$pPassword = $_POST['hashed_pass'];
		$checkQuery->execute();
		$checkQuery->store_result();
		if($checkQuery->num_rows() == 1){
			print('<p>Access Granted!</p>');
			$loginQuery->bind_result($uid, $name, $adminlevel, $eventadmin);
			$loginQuery->fetch();
			$_SESSION['uid'] = $uid;
			$_SESSION['name'] = $name;
			$_SESSION['adminlevel'] = $adminlevel;
			$_SESSION['eventadmin'] = $eventadmin;
			$_SESSION['is_society'] = 0;
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=tests/test_login.php">';
		}
		else{
			print('Wrong email or password! Please try again!');
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=registration.php">';
		}
	?>
</body>
</html>