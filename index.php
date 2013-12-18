<?php
	/*
		AUTHOR: andrewjkerr <andrewjkerr47@gmail.com>
		DESCRIPTION: Homepage!
		USAGE: Just load it up :)
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
			height: 825px;
		}
	</style>
	
</head>
<body>
	<?php
		include("template/header.php");
		include("template/nav.php");
	?>
	<div id = "container">
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
						$numAnnouncements;
						for($j = 0; $j < $numAnnouncements; $j++){
							echo "<p>" . $obj[$j]->id . ": " . $obj[$j]->text . "</p>";
						}
					*/
					foreach($obj as $i){
						echo "<p>" . $i->id . ": " . $i->text . "</p>";
					}
				?>
			</div>
		</div>
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
		<div id = "login">
			<form method="post" action="login.php">
				<p>Email: <input type="text" name="email" style="width: 100%"/></p>
				<p>Password: <input type="password" id="password" style="width: 100%" onkeyup="hashpass();"/></p>
				<p><input type="hidden" id="hashed_pass" name="hashed_pass" /></p>
				<p><input type="submit" id="my_submit" /></p>
			</form>
		</div>
		<div id = "tweets">
			<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/andrewuf" data-widget-id="413242474895667200">Tweets by @andrewuf (Turn Disconnect off you dummy!)</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
	</div>
	<?php
		include("template/footer.php");
	?>
</body>
</html>