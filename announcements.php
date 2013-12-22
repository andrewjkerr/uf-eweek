<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Announcement Manager
		USAGE: Manages announcements!
		TO-DO:
			- Add dates to announcements
			- Add "announcement_history" table to database
	*/
	require('mysql_connect.php');
	session_start();
	if($_SESSION['adminlevel'] == 0 || $_SESSION['adminlevel'] == 1){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=auth_error.php">';
		exit();
	}
	if(!empty($_POST['id-edit'])){
		$query = mysqli_prepare($link, 'UPDATE announcements SET text=? WHERE id=?');
		$query->bind_param("ss", $pEdit, $pID);
		$pID = $_POST['id-edit'];
		$pEdit = $_POST['announcement-edit'];
		$query->execute();
		$_SESSION['edit-success'] = true;
	}
	if(!empty($_POST['id-delete'])){
		$query = mysqli_prepare($link, 'DELETE FROM announcements WHERE id=?');
		$query->bind_param("s", $pID);
		$pID = $_POST['id-delete'];
		$query->execute();
		$_SESSION['delete-success'] = true;
	}
	if(!empty($_POST['announcement-add'])){
		$query = mysqli_prepare($link, 'INSERT INTO announcements (id, text) VALUES (NULL, ?)');
		$query->bind_param("s", $pText);
		$pText = $_POST['announcement-add'];
		$query->execute();
		$_SESSION['add-success'] = true;
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
		
		.delete{
			display: inline;
			cursor: hand;
		}
		.add{
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
			$(".delete-form").hide();
			$(".delete").click(function()
			{
				$(this).nextAll(".delete-form:first").slideToggle(500);
			})
			$(".add-form").hide();
			$(".add").click(function()
			{
				$(this).nextAll(".add-form:first").slideToggle(500);
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
				echo '<div class="add"><h2>Add announcement!</h2></div>';
				echo '<div class="add-form">
					<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
						<textarea cols="75" rows="5" name="announcement-add"></textarea>
						<p><input type="submit" /></p>
					</form>
				</div>';
				$url = "http://localhost/~andrewjkerr/eweek/get_announcements.php";
				$json = file_get_contents($url);
				$obj = json_decode($json);
				foreach($obj as $i){
					echo "<p>" . $i->text . "</p>";
					echo '<p><div class="edit">[Edit]</div> | <div class="delete">[Delete]</div></p>';
					echo '<div class="edit-form">
							<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
								<textarea cols="75" rows="5" name="announcement-edit">' . $i->text . '</textarea>
								<input type="hidden" name="id-edit" value="' . $i->id . '" /> 
								<p><input type="submit" /></p>
							</form>
						</div>';
					echo '<div class="delete-form">
						<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
							<input type="hidden" name="id-delete" value="' . $i->id . '" /> 
							<p><input type="submit" value="Confirm Deletion" /></p>
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
		if($_SESSION['delete-success'] && !empty($_POST['id-delete'])){
			echo '<script>alert("That announcement has been deleted!");</script>';
		}
		unset($_SESSION['delete-success']);
		if($_SESSION['add-success'] && !empty($_POST['announcement-add'])){
			echo '<script>alert("Your announcement has been added!");</script>';
		}
		unset($_SESSION['add-success']);
		
	?>

</body>
</html>