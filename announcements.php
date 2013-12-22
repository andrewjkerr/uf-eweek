<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Announcement Manager
		USAGE: Manages announcements!
		TO-DO:
	*/
	session_start();
	if($_SESSION['adminlevel'] == 0 || $_SESSION['adminlevel'] == 1){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=auth_error.php">';
		exit();
	}
	if(!empty($_POST['id-edit'])){
		require('mysql_connect.php');
		$query = mysqli_prepare($link, 'UPDATE announcements SET text=? WHERE id=?');
		$query->bind_param("ss", $pEdit, $pID);
		$pID = $_POST['id-edit'];
		$pEdit = $_POST['announcement-edit'];
		$query->execute();
		$_SESSION['edit-success'] = true;
	}
?>
<html>
<head>
	<title>UF E-Week | Announcement Manager</title>
	
	<!-------------
		STYLE
	-------------->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style>
		/* In this case, since the content size is dynamic, we add this to the content div. */
		#content{
			background-color: #fff;
			width: 97%;
			margin-bottom: 37px;
			border-bottom: 3px solid black;
		}
		
		.edit{
			display: inline;
			cursor: hand;
		}
	</style>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".edit-form").hide();
			$(".edit").click(function()
			{
				$(this).nextAll(".edit-form:first").slideToggle(500);
			})
		});
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
			<h1>Announcement Manager</h1>
			<?php
				echo '<p>Hello, ' . $_SESSION['name'] . ' and welcome to the announcement management system! (v0.1)</p>';
				echo '<hr />';
				$url = "http://localhost/~andrewjkerr/eweek/get_announcements.php";
				$json = file_get_contents($url);
				$obj = json_decode($json);
				foreach($obj as $i){
					echo "<p>" . $i->text . "</p>";
					echo '<p><div class="edit">[Edit]</div> | <a href="announcements.php?delete=' . $i->id . '">[Delete]</a></p>';
					echo '<div class="edit-form">
							<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
								<textarea cols="75" rows="5" name="announcement-edit">' . $i->text . '</textarea>
								<input type="hidden" name="id-edit" value="' . $i->id . '" /> 
								<p><input type="submit" /></p>
							</form>
						</div>';
					echo "<hr />";
				}
				
			?>
		</div>
	</div>
	
	<!-------------
		FOOTER
	-------------->
	<?php
		include("template/footer.php");
		if($_SESSION['edit-success'] && !empty($_POST['id-edit'])){
			echo '<script>alert("Your announcement has been updated!");</script>';
		}
		unset($_SESSION['edit-success']);
	?>

</body>
</html>