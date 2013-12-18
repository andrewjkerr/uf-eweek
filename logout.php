<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Logout!
		USAGE: Logs the user out and redirects to the homepage.
		TO-DO:
			
	*/
	session_start();
?>
<html>
<head>
	<title>UF E-Week</title>
	
	<!-------------
		STYLE
	-------------->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style>
		#container{
			height: 300px;
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
		<div id="content">
			<h1>Logging you out...</h1>
			<?php
				session_destroy();
				echo "Logout successful. Hope to see you soon!";
				echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.php">';
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