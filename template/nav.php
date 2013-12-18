<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Nav
		USAGE: Any modifications to the code go here. CSS for the nav can be found in css/main.css
		TO-DO:
			- Add rest of links!
			- Moar styling
			- Fix "Register" link on registration.php page
	*/
?>
<nav>
	<?php
		if (isset($_SESSION['uid'])){
	    	echo '<a href="index.php">Home</a> | <a href="logout.php">Logout</a>';
		}
		else{
			echo '<a href="index.php">Home</a> | <a href="registration.php">Login</a> | <a href="registration.php#register">Register</a>';
		}
	?>
</nav>