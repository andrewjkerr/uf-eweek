<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Registration
		USAGE: Registers users/login others!
	*/
?>
<html>
<head>
	<title>UF E-Week</title>
	
	<!-------------
		SCRIPTS
	-------------->
	<!-- https://code.google.com/p/crypto-js/#SHA-3 -->
	<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha3.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script>
	function hashpass(){
		var password = document.getElementById('password').value;
		var hashed = CryptoJS.SHA3(password);
		document.getElementById('hashed_pass').value = hashed;
	}
	</script>
	
	<script>
		var loginHeight = 320;
		var registerHeight = 600;
        $(document).ready(function() {
        	var curswitch = window.location.hash;
        	if(curswitch == "#register"){
	        	$("#login").hide();
	        	$("#container").css({"height":registerHeight});
        	}
        	else{
	        	$("#register").hide();
	        	$("#container").css({"height":loginHeight});
        	}
        });
        
        function hideLogin(){
			$("#login").hide();
			$("#register").slideToggle(500);
			$("#container").css({"height":registerHeight});
		}
		
		function hideRegistration(){
			$("#register").hide();
			$("#login").slideToggle(500);
			$("#container").css({"height":loginHeight});
		}
	</script>
	
	<!-------------
		STYLE
	-------------->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/registration.css">
	<style>
		#container{
			height: 400px;
		}
	</style>
	
</head>
<body>
	<!-------------
		HEADER/NAV
	-------------->
	<?php
		include("template/header.php");
		include("template/nav.php");
	?>
	
	<!-------------
		CONTAINER
	-------------->
	<div id = "container">
		<table id="registration-table">
			<tr>
				<td id="left-side">
					<div id="login">
						<h1>Login!</h1>
						<p><em><a onclick="hideLogin();" href="#register">Need to register? Click here!</a></em></p>
						<form id="login-form" method="post" action="login.php">
							<p>Email:</p>
							<p><input type="text" name="email" style="width: 300px"/></p>
							<p>Password:</p>
							<p><input type="password" id="password" style="width: 300px" onkeyup="hashpass();"/></p>
							<p><input type="hidden" id="hashed_pass" name="hashed_pass" /></p>
							<p><input type="submit" id="my_submit" /></p>
						</form>
					</div>
					<div id="register">
						<h1>Register!</h1>
						<p><em><a onclick="hideRegistration();" href="#">Already have an account and need to login? Click here!</a></em></p>
						<form id="registration-form" method="post" action="register.php">
							<p>Email:</p>
							<p><input type="text" name="email" style="width: 300px"/></p>
							<p>Password:</p>
							<p><input type="password" id="password" style="width: 300px" /></p>
							<p>Confirm Password:</p>
							<p><input type="password" id="confirm_password" style="width: 300px" onkeyup="hashpass();"/></p>
							<p>Name:</p>
							<p><input type="text" name="name" style="width: 300px"/></p>
							<p>Society lists:</p>
							<!-- list societies here -->
							<p><input type="hidden" id="hashed_pass" name="hashed_pass" /></p>
							<p><input type="submit" id="my_submit" /></p>
						</form>
					</div>
				</td>
				<td id="right-side">
					<h1>Advantages to Registering</h1>
					<ul>
						<li>RSVP to events!</li>
						<li>Quick attendence!</li>
						<li>Earn points for your society!</li>
						<li>The limit of advantages does not exist!</li>
					</ul>
				</td>
			</tr>
		</table>
	</div>
	
	<!-------------
		FOOTER
	-------------->
	<?php
		include("template/footer.php");
	?>
</body>
</html>