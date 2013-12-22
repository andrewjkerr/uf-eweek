<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Event Manager
		USAGE: Manages events!
		TO-DO:
			- Database changes to events (event image!)
	*/
	require('mysql_connect.php');
	session_start();
	if($_SESSION['adminlevel'] == 0 || $_SESSION['adminlevel'] == 2 || $_SESSION['adminlevel'] == 3){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=auth_error.php">';
		exit();
	}
	if(!empty($_POST['id-edit'])){
		$query = mysqli_prepare($link, 'UPDATE events SET name=?, description=?, date=?, location=? WHERE id=?') or die();
		$query->bind_param("sssss", $pName, $pDescription, $pDate, $pLocation, $pID);
		$pID = $_POST['id-edit'];
		$pName = $_POST['name-edit'];
		$pDescription = $_POST['description-edit'];
		$pDate = $_POST['date-edit'];
		$pLocation = $_POST['location-edit'];
		$query->execute();
		$_SESSION['edit-success'] = true;
	}
	if(!empty($_POST['id-delete'])){
		$query = mysqli_prepare($link, 'DELETE FROM events WHERE id=?');
		$query->bind_param("s", $pID);
		$pID = $_POST['id-delete'];
		$query->execute();
		$_SESSION['delete-success'] = true;
	}
	if(!empty($_POST['name-add'])){
		$query = mysqli_prepare($link, 'INSERT INTO events (id, name, shortname, description, date, location) VALUES (NULL, ?, ?, ?, ?, ?)');
		$query->bind_param("sssss", $pName, $pShort, $pDescription, $pDate, $pLocation);
		$pName = $_POST['name-add'];
		$pShort = $_POST['short-add'];
		$pDescription = $_POST['description-add'];
		$pDate = $_POST['date-add'];
		$pLocation = $_POST['location-add'];
		$query->execute();
		$_SESSION['add-success'] = true;
	}
?>
<html>
<head>
	<title>UF E-Week | Event Manager</title>
	
	<!-------------
		STYLE
	-------------->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<style>
		/* In this case, since the content size is dynamic, we add this to the content div. */
		#content{
			background-color: #fff;
			width: 97%;
			margin-bottom: 31px;			
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
			$(".event-details").hide();
			$(".edit").click(function()
			{
				$(this).nextAll(".event-details:first").slideToggle(500);
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
			<?php
			
				/*
					<!-------------
						EVENT DIRECTORS
					-------------->
					Description: Allows event director to edit their events.

				*/
				if($_SESSION['adminlevel'] == 1){
					$url = "http://localhost/~andrewjkerr/eweek/get_event.php?id=" . $_SESSION['eventadmin'];
					$json = file_get_contents($url);
					$obj = json_decode($json);
					echo "<h1>Event Manager: " . $obj[0]->name . "</h1>";
					echo '<p>Hello, ' . $_SESSION['name'] . ' and welcome to the event management system! (v0.1)</p>';
					echo '<p>You are currently managing: ' . $obj[0]->name . '</p>';
					echo '<hr />';
					echo '<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
						<p>Name: <input type="type" name="name-edit" value="' . $obj[0]->name . '" /></p>
						<p>Description:</p>
						<p><textarea cols="75" rows="5" name="description-edit">' . $obj[0]->description . '</textarea></p>
						<p>Date: <input type="type" name="date-edit" value="' . $obj[0]->date . '" /></p>
						<p>Location: <input type="type" name="location-edit" value="' . $obj[0]->location . '" /></p>
						<input type="hidden" name="id-edit" value="' . $obj[0]->id . '" /> 
						<p><input type="submit" value="Confirm Edit" /></p>
					</form>';
				}
				
				/*
					<!-------------
						EWEEK DIRECTOR & TECH DIRECTOR
					-------------->
					Description: Lists all of the events and allows for deletion/editing.
				*/
				else{
					echo '<p>Hello, ' . $_SESSION['name'] . ' and welcome to the event management system! (v0.1)</p>';
					echo '<div class="add"><h2>Add event!</h2></div>';
					echo '<div class="add-form">
						<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
							<p>Name: <input type="type" name="name-add" /></p>
							<p>Short name: <input type="type" name="short-add" /></p>
							<p>Description:</p>
							<p><textarea cols="75" rows="5" name="description-add"></textarea></p>
							<p>Date: <input type="type" name="date-add" /></p>
							<p>Location: <input type="type" name="location-add" /></p>
							<p><input type="submit" value="Add Event" /></p>
						</form>
					</div>';
					echo '<hr />';
					$json = file_get_contents('http://localhost/~andrewjkerr/eweek/get_event.php?id=all');
					$obj = json_decode($json);
					foreach($obj as $i){
						echo '<p>' . $i->name . '</p>';
						echo '<p><div class="edit">[Edit]</div> | <div class="delete">[Delete]</div></p>';
						echo '<div class="event-details">
								<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
									<p>Name: <input type="type" name="name-edit" value="' . $i->name . '" /></p>
									<p>Description:</p>
									<p><textarea cols="75" rows="5" name="description-edit">' . $i->description . '</textarea></p>
									<p>Date: <input type="type" name="date-edit" value="' . $i->date . '" /></p>
									<p>Location: <input type="type" name="location-edit" value="' . $i->location . '" /></p>
									<input type="hidden" name="id-edit" value="' . $i->id . '" /> 
									<p><input type="submit" value="Confirm Edit" /></p>
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
			echo '<script>alert("Your event has been updated!");</script>';
		}
		unset($_SESSION['edit-success']);	
		if($_SESSION['delete-success'] && !empty($_POST['id-delete'])){
			echo '<script>alert("That announcement has been deleted!");</script>';
		}
		unset($_SESSION['delete-success']);
		if($_SESSION['add-success'] && !empty($_POST['event-add'])){
			echo '<script>alert("Your announcement has been added!");</script>';
		}
		unset($_SESSION['add-success']);	
	?>

</body>
</html>