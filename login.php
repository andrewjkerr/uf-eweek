<?php
	include('mysql_connect.php');
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
			$checkQuery->bind_result($uid, $name, $email, $password);
			$checkQuery->fetch();
			$_SESSION['uid'] = $uid;
			$_SESSION['name'] = $name;
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.php">';
		}
		else{
			print('Wrong!');
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.php">';
		}
	?>
</body>
</html>
		