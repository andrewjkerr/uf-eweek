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
?>
<html>
<head>
	<title>UF E-Week | User Manager</title>
	
	<!-------------
		STYLE
	-------------->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="scripts/SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css" />
	<style>
		/* In this case, since the content size is dynamic, we add this to the content div. */
		#content{
			background-color: #fff;
			width: 97%;
			margin-bottom: 31px;
			border-bottom: 3px solid black;
		}
	</style>
	<script src="scripts/SlickGrid/lib/jquery-1.7.min.js"></script>
	<script src="scripts/SlickGrid/lib/jquery-ui-1.8.16.custom.min.js"></script>
	<script src="scripts/SlickGrid/lib/jquery.event.drag-2.2.js"></script>
	<script src="scripts/SlickGrid/plugins/slick.cellrangedecorator.js"></script>
	<script src="scripts/SlickGrid/plugins/slick.cellrangeselector.js"></script>
	<script src="scripts/SlickGrid/plugins/slick.cellselectionmodel.js"></script>
	<script src="scripts/SlickGrid/slick.core.js"></script>
	<script src="scripts/SlickGrid/slick.formatters.js"></script>
	<script src="scripts/SlickGrid/slick.editors.js"></script>
	<script src="scripts/SlickGrid/slick.grid.js"></script>
	<script>
	  function requiredFieldValidator(value) {
	    if (value == null || value == undefined || !value.length) {
	      return {valid: false, msg: "This is a required field"};
	    } else {
	      return {valid: true, msg: null};
	    }
	  }

	  var grid;
	  var data = [];
	  var columns = [
	    {id: "title", name: "Title", field: "title", width: 120, cssClass: "cell-title", editor: Slick.Editors.Text, validator: requiredFieldValidator},
	    {id: "desc", name: "Description", field: "description", width: 100, editor: Slick.Editors.LongText},
	    {id: "duration", name: "Duration", field: "duration", editor: Slick.Editors.Text},
	    {id: "%", name: "% Complete", field: "percentComplete", width: 80, resizable: false, editor: Slick.Editors.PercentComplete},
	    {id: "start", name: "Start", field: "start", minWidth: 60, editor: Slick.Editors.Date},
	    {id: "finish", name: "Finish", field: "finish", minWidth: 60, editor: Slick.Editors.Date},
	    {id: "effort-driven", name: "Effort Driven", width: 80, minWidth: 20, maxWidth: 80, cssClass: "cell-effort-driven", field: "effortDriven", formatter: Slick.Formatters.Checkmark, editor: Slick.Editors.Checkbox}
	  ];
	  var options = {
	    editable: true,
	    enableAddRow: true,
	    enableCellNavigation: true,
	    asyncEditorLoading: false,
	    autoEdit: false
	  };

	  $(function () {
	    for (var i = 0; i < 500; i++) {
	      var d = (data[i] = {});

	      d["title"] = "Task " + i;
	      d["description"] = "This is a sample task description.\n  It can be multiline";
	      d["duration"] = "5 days";
	      d["percentComplete"] = Math.round(Math.random() * 100);
	      d["start"] = "01/01/2009";
	      d["finish"] = "01/05/2009";
	      d["effortDriven"] = (i % 5 == 0);
	    }

	    grid = new Slick.Grid("#myGrid", data, columns, options);

	    grid.setSelectionModel(new Slick.CellSelectionModel());

	    grid.onAddNewRow.subscribe(function (e, args) {
	      var item = args.item;
	      grid.invalidateRow(data.length);
	      data.push(item);
	      grid.updateRowCount();
	      grid.render();
	    });
	  })
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
			<div id="myGrid"></div>
			<?php
				/*echo '<p>Hello, ' . $_SESSION['name'] . ' and welcome to the user management system! (v0.1)</p>';
				echo '<hr />';
				$result = mysqli_query($link, "SELECT id, name, email, adminlevel, eventadmin, soc1, soc2, soc3 FROM users"); 
				$json = mysqli_fetch_all($result, MYSQLI_ASSOC);
				$json = json_encode($json);
				$obj = json_decode($json);
				echo '<table>
					<tr>
						<td>ID</td>
						<td>Name</td>
						<td>Email</td>
						<td>Admin</td>
						<td>Society 1</td>
						<td>Society 2</td>
						<td>Society 3</td>
						<td>Edit</td>
						<td>Delete</td>
					</tr>';
				foreach($obj as $i){
					echo "<tr><td>" . $i->id . "</td>";
					echo '<td>' . $i->name . '</td>';
					echo '<td>' . $i->email . '</td>';
					echo '<td>' . $i->adminlevel . '</td>';
					echo '<td>' . $i->eventadmin . '</td>';
					echo '<td>' . $i->soc1 . '</td>';
					echo '<td>' . $i->soc2 . '</td>';
					echo '<td>' . $i->soc3 . '</td>';
					echo '<td><div class="edit">[Edit]</div>
						<td><div class="delete">[Delete]</div></td></tr>';
					/*echo '<div class="edit-form">
							<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
								<textarea cols="75" rows="5" name="announcement-edit">' . $i->text . '</textarea>
								<input type="hidden" name="id-edit" value="' . $i->id . '" /> 
								<p><input type="submit" /></p>
							</form>
						</div>';
					echo '<tr class="delete-form"><td colspan=7>
						<form method="post" action="'. $_SERVER['$PHP_SELF'] . '">
							<input type="hidden" name="id-delete" value="' . $i->id . '" /> 
							<p><input type="submit" value="Confirm Deletion" /></p>
						</form></td></tr>';
				}
				echo '</table>';*/
				
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