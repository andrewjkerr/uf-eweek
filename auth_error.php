<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Displays an authentication error!
		USAGE: Direct to this page when user does not have authorization :)
		TO-DO:
			
	*/
	session_start();
?>
<html>
<head>
	<title>UF E-Week | Authentication Error</title>
	
	<!-------------
		STYLE
	-------------->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style>
		#container{
			height: 300px;
		}
		
		#content{
			width: 97%;
		}
	</style>
	<script type="text/javascript">
	function countdown() {
	    var i = document.getElementById('counter');
	    if (parseInt(i.innerHTML)<=0) {
	        location.href = 'registration.php';
	    }
	    i.innerHTML = parseInt(i.innerHTML)-1;
	}
	setInterval(function(){ countdown(); },1000);
	</script>
	<script type="text/javascript">
	function countdown2() {
	    var j = document.getElementById('counter-login');
	    if(parseInt(j.innerHTML)<=0){
		    location.href = 'index.php';
	    }
	    j.innerHTML = parseInt(j.innerHTML)-1;
	}
	setInterval(function(){ countdown2(); },1000);
	</script>
	
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
		<div id="content">
			<?php
				if (!isset($_SESSION['uid'])){
		    		echo '<h1>You are not logged in!</h1>';
		    		echo '<p>You will be redirected to the login page in... <span id="counter">5</span>.</p>';
		    		echo '<em><a href="registration.php">Click here if you are not redirected.</a></em>';
				}
				else{
					echo '<h1>You are not authorized for this area!</h1>';
					echo '<p>Hello, ' . $_SESSION['name'] . '! You are trying to access a section of the UF E-Week website that you are not supposed to be poking around in! Please don\'t do this again :)</p>';
					echo '<p>You will be redirected back to the homepage in... <span id="counter-login">5</span>.</p>';
					echo '<em><a href="index.php">Click here if you are not redirected.</a></em>';
				}
			?>
		</div>
	</div>
	
	<!-------------
		FOOTER
	-------------->
	<?php
		include("template/footer.php");
	?>
</body>
</html>