<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: User Manager
		USAGE: Manages users!
		TO-DO:
			
	*/
	require('mysql_connect.php');
	session_start();
	if($_SESSION['adminlevel'] != 5){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=auth_error.php">';
		exit();
	}
	if(!empty($_POST['id-edit'])){
		if($_POST['password-changed'] == "true"){
			$query = mysqli_prepare($link, 'UPDATE users SET name=?, email=?, password=?, adminlevel=?, eventadmin=?, soc1=?, soc2=?, soc3=? WHERE id=?') or die();
			$query->bind_param("sssssssss", $pName, $pEmail, $pHash, $pAdmin, $pEvent, $pSoc1, $pSoc2, $pSoc3, $pID);
			$pHash = $_POST['hashed-edit'];
			echo $_POST['id-edit'];
		}
		else{
			$query = mysqli_prepare($link, 'UPDATE users SET `name`=?, `email`=?, `adminlevel`=?, `eventadmin`=?, `soc1`=?, `soc2`=?, `soc3`=? WHERE `id`=?') or die();
			$query->bind_param("ssssssss", $pName, $pEmail, $pAdmin, $pEvent, $pSoc1, $pSoc2, $pSoc3, $pID);
		}
		$pID = $_POST['id-edit'];
		$pName = $_POST['name-edit'];
		$pEmail = $_POST['email-edit'];
		$pAdmin = $_POST['admin-edit'];
		$pEvent = $_POST['event-edit'];
		$pSoc1 = $_POST['soc1-edit'];
		$pSoc2 = $_POST['soc2-edit'];
		$pSoc3 = $_POST['soc3-edit'];
		$query->execute();
		$_SESSION['edit-success'] = true;
	}
	if(!empty($_POST['id-delete'])){
		$query = mysqli_prepare($link, 'DELETE FROM users WHERE id=?');
		$query->bind_param("s", $pID);
		$pID = $_POST['id-delete'];
		$query->execute();
		$_SESSION['delete-success'] = true;
	}
?>
<html>
<head>
	<title>UF E-Week | User Manager</title>
	
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
		.floatedCell{
		    float:left;
		    width: 50px%;
		    height: 30px;
			padding-left: 10px;
		}
		.floatedCellID{
		    float:left;
		    border-right: 1px solid black;
		    width: 30px;
		    height: 30px;
		}
		.floatedCellName{
		    float:left;
		    border-right: 1px solid black;
		    width: 190px;
		    height: 30px;
			padding: 0 10px;
		}
		.floatedCellEmail{
		    float:left;
		    border-right: 1px solid black;
		    width: 280px;
		    height: 30px;
			padding: 0 10px;
		}
		.floatedCellAdmin{
		    float:left;
		    border-right: 1px solid black;
		    width: 50px;
		    height: 30px;
			text-align: center;
		}
		.floatedCellEvent{
		    float:left;
		    border-right: 1px solid black;
		    width: 50px;
		    height: 30px;
			text-align: center;
		}
		.floatedCellSoc{
		    float:left;
		    border-right: 1px solid black;
		    width: 70px;
		    height: 30px;
			text-align: center;
		}
		.clear{
		    clear: both;
		}
	</style>
	
	<!-------------
		SCRIPTS
	-------------->
		
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".edit-row").hide();
			$(".edit").click(function()
			{
				$(this).closest(".row").nextAll(".edit-row:first").slideToggle(500);
			})
			$(".delete-row").hide();
			$(".delete").click(function()
			{
				$(this).closest(".row").nextAll(".delete-row:first").slideToggle(500);
			})
		});
	</script>
	
	<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha3.js"></script>
	<script>
	function hashpass(){
		var password = document.getElementById('password-edit').value;
		/*if(password != ""){
			document.getElementById('password-changed').value = "true";
		}
		else{
			document.getElementById('password-changed').value = "false";
		}*/
		var hashed = CryptoJS.SHA3(password);
		document.getElementById('hashed-edit').value = hashed;
	}
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
			<h1>User Manager</h1>
			<?php
				echo '<p>Hello, ' . $_SESSION['name'] . ' and welcome to the user management system! (v0.1)</p>';
				echo '<hr />';
				$result = mysqli_query($link, "SELECT id, name, email, adminlevel, eventadmin, soc1, soc2, soc3 FROM users"); 
				$json = mysqli_fetch_all($result, MYSQLI_ASSOC);
				$json = json_encode($json);
				$obj = json_decode($json);
				echo '<div class="table">';
					echo '<div class="row">';
						echo '<div class="floatedCellID">ID</div>';
						echo '<div class="floatedCellName">Name</div>';
						echo '<div class="floatedCellEmail">Email</div>';
						echo '<div class="floatedCellAdmin">Admin</div>';
						echo '<div class="floatedCellEvent">Event</div>';
						echo '<div class="floatedCellSoc">Society 1</div>';
						echo '<div class="floatedCellSoc">Society 2</div>';
						echo '<div class="floatedCellSoc">Society 3</div>';
						echo '<div class="clear"></div>';
					echo '</div>';
					foreach($obj as $i){
						echo '<div class="row">';
							echo '<div class="floatedCellID">' . $i->id . '</div>';
							echo '<div class="floatedCellName">' . $i->name . '</div>';
							echo '<div class="floatedCellEmail">' . $i->email . '</div>';
							echo '<div class="floatedCellAdmin">' . $i->adminlevel . '</div>';
							echo '<div class="floatedCellEvent">' . $i->eventadmin . '</div>';
							echo '<div class="floatedCellSoc">' . $i->soc1 . '</div>';
							echo '<div class="floatedCellSoc">' . $i->soc2 . '</div>';
							echo '<div class="floatedCellSoc">' . $i->soc3 . '</div>';
							echo '<div class="floatedCell"><div class="edit">[Edit]</div></div>';
							echo '<div class="floatedCell"><div class="delete">[Delete]</div></div>';
							echo '<div class="clear"></div>';
						echo '</div>';
						echo '<div class="edit-row">';
							echo '<form method="post" action="' . $_SERVER['$PHP_SELF'] . '">
									<input type="hidden" name="id-edit" value="' . $i->id . '" />
									<p>Name: <input type="text" name="name-edit" value="' . $i->name . '" /></p>
									<p>Email: <input type="text" name="email-edit" value="' . $i->email . '" /></p>
									<p>Password: <input type="text" id="password-edit" onkeyup="hashpass();"/></p>
									<p>Admin Level: <input type="text" name="admin-edit" value="' . $i->adminlevel . '" /></p>
									<p>Event Admin: <input type="text" name="event-edit" value="' . $i->eventadmin . '" /></p>
									<p>Society 1: <input type="text" name="soc1-edit" value="' . $i->soc1 . '" /> | Society 2: <input type="text" name="soc2-edit" value="' . $i->soc2 . '" /> | Society 3: <input type="text" name="soc3-edit" value="' . $i->soc3 . '" /></p>
									<p><input type="text" name="hashed-edit" id="hashed-edit" /></p>
									<p><input type="text" name="password-changed" id="password-changed" value="false" /></p>
									<p><input type="submit" value="Confirm Edit" /></p>
								</form>';
						echo '</div>';
						echo '<div class="delete-row">
								<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
									<input type="hidden" name="id-delete" value="' . $i->id . '" /> 
									<p><input type="submit" value="Confirm Deletion" /></p>
								</form>
							</div>';
					}
				echo '</div>';
				
			?>
		</div>
	</div>
	
	<!-------------
		FOOTER
	-------------->
	<?php
		include("template/footer.php");
		if($_SESSION['edit-success'] && !empty($_POST['id-edit'])){
			echo '<script>alert("The user has been updated!");</script>';
		}
		unset($_SESSION['edit-success']);
		if($_SESSION['delete-success'] && !empty($_POST['id-delete'])){
			echo '<script>alert("The user has been deleted!");</script>';
		}
		unset($_SESSION['delete-success']);
		
	?>

</body>
</html>