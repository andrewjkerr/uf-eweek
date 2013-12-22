<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Homepage!
		USAGE: Just load it up :)
		TO-DO:
			- Link events to event info
			- Add dates to announcements
			- Add validation to login <http://jqueryvalidation.org/>
			- Show user control panel when logged in in #login!
	*/
	session_start();
?>
<html>
<head>
	<title>UF E-Week</title>
	
	<!-------------
		SCRIPTS
	-------------->
	<!-- https://code.google.com/p/crypto-js/#SHA-3 -->
	<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha3.js"></script>
	<script>
	function hashpass(){
		var password = document.getElementById('password').value;
		var hashed = CryptoJS.SHA3(password);
		document.getElementById('hashed_pass').value = hashed;
	}
	</script>
	
	<!-------------
		STYLE
	-------------->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<style>
		#container{
			height: 875px;
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
		<!-- Homepage welcome/announcements -->
		<div id = "content">
			<h1>Hello, World!</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam odio est, imperdiet ac bibendum at, ultricies vel erat. Donec consectetur neque id lorem ullamcorper, posuere facilisis lorem aliquet. Ut sem leo, eleifend in eros vitae, interdum lacinia augue. Nunc lacus eros, aliquet ac aliquam mollis, euismod id leo. Ut a lacus vel lorem auctor mattis. Donec mollis fermentum libero, ut ultricies lorem vehicula a. Integer nulla quam, scelerisque vitae tristique eu, ornare quis lacus. Nunc tristique rutrum quam ac elementum. Etiam hendrerit dapibus quam sed gravida. Nulla tincidunt sollicitudin dui, sit amet suscipit justo.</p>
			<div id="announcements">
				<h2>Announcements</h2>
				<?php
					$url = "http://localhost/~andrewjkerr/eweek/get_announcements.php";
					$json = file_get_contents($url);
					$obj = json_decode($json);
					/*
						Why is this here? Well, if the number of announcements goes off the page, reduce it!
						$numAnnouncements = 5;
						for($j = 0; $j < $numAnnouncements; $j++){
							echo "<p>" . $obj[$j]->id . ": " . $obj[$j]->text . "</p>";
						}
					*/
					foreach($obj as $i){
						echo '<div class="announcement">';
						echo "<p>" . $i->text . "</p>";
						echo '<hr style="width: 420px; margin: 0 auto;" />';
						echo '</div>';
					}
				?>
			</div>
		</div>
		
		<!-- Event calendar -->
		<div id = "cal">
			<h2>Schedule of Events</h2>
			<?php
				$json = file_get_contents('http://localhost/~andrewjkerr/eweek/get_event.php?id=all');
				$obj = json_decode($json);
				foreach($obj as $i){
					echo "<div class = 'event'>";
					echo "<div class = 'event-name'><b>" . $i->name . "</b></div>";
					echo "<div class = 'event-time'><em>" . $i->date . "</em></div>";
					echo "</div>";
					echo "<br />";
				}
			?>
		</div>
		
		<!-- Login form -->
		<div id = "login">
			<?php
				if (!isset($_SESSION['uid'])){
		    		echo '<form method="post" action="login.php">
							<p>Email: <input type="text" name="email" style="width: 100%"/></p>
							<p>Password: <input type="password" id="password" style="width: 100%" onkeyup="hashpass();"/></p>
							<p><input type="hidden" id="hashed_pass" name="hashed_pass" /></p>
							<p><input type="submit" id="my_submit" /></p>
							<p><em><a href="registration.php#register">Don\'t have an account? Register!</a></em></p>
						</form>';
				}
				else{
					echo 'Hello, ' . $_SESSION['name'] . '!';
					echo '<ul>';
					switch($_SESSION['adminlevel']){
						case 0:
							echo '<li>You are a proud engineer!</li>';
							echo '<li><a href="events.php">View and RSVP for events!</a></li>';
							echo '<li><a href="logout.php">Logout</a></li>';
							break;
						case 1:
							echo '<li>You are an event admin</li>';
							if($_SESSION['eventadmin'] != '0'){
								echo '<li><a href="manage_event.php?' . $_SESSION['eventadmin'] . '">Manage ' . $_SESSION['eventadmin'] . '</a></li>';
								echo '<li><a href="events.php">View and RSVP for events!</a></li>';
								echo '<li><a href="logout.php">Logout</a></li>';
							}
							break;
						case 2:
							echo '<li>You are advertising director</li>';
							echo '<li><a href="announcements.php">Add announcement</a></li>';
							echo '<li><a href="events.php">View and RSVP for events!</a></li>';
							echo '<li><a href="logout.php">Logout</a></li>';
							break;
						case 3:
							echo '<li>You are attendant</li>';
							echo '<li><a href="announcements.php">Add announcement</a></li>';
							echo '<li><a href="mulan/index.php">Access Mulan</a></li>';
							echo '<li><a href="events.php">View and RSVP for events!</a></li>';
							echo '<li><a href="logout.php">Logout</a></li>';
							break;
						case 4:
							echo '<li>You are director of eweek</li>';
							echo '<li><a href="announcements.php">Add announcement</a></li>';
							echo '<li><a href="mulan/index.php">Access Mulan</a></li>';
							echo '<li><a href="manage_event.php">Manage events</a></li>';
							echo '<li><a href="events.php">View and RSVP for events!</a></li>';
							echo '<li><a href="logout.php">Logout</a></li>';
							break;
						case 5:
							echo '<li>You are super admin!</li>';
							echo '<li><a href="announcements.php">Add announcement</a></li>';
							echo '<li><a href="mulan/index.php">Access Mulan</a></li>';
							echo '<li><a href="manage_event.php">Manage events</a></li>';
							echo '<li><a href="manageUsers.php">Manage users</a></li>';
							echo '<li><a href="events.php">View and RSVP for events!</a></li>';
							echo '<li><a href="logout.php">Logout</a></li>';
							break;
					}
					echo '</ul>';
				}
			?>
		</div>
		
		<!-- Display tweets! -->
		<div id = "tweets">
			<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/andrewuf" data-widget-id="413242474895667200">Tweets by @andrewuf (Turn Disconnect off you dummy!)</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
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