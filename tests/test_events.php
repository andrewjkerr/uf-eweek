<?php
	$json = file_get_contents('http://localhost/~andrewjkerr/eweek/get_event.php?id=all');
	$obj = json_decode($json);
	foreach($obj as $i){
		echo "<p>" . $i->id . ": " . $i->name . "</p>";
	}
	echo "-------------------------------";
	for($j = 1; $j <= 3; $j++){
		$url = "http://localhost/~andrewjkerr/eweek/get_event.php?id=test" . $j;
		$json1 = file_get_contents($url);
		$obj1 = json_decode($json1);
		echo "<p>" . $obj1[0]->id . ": " . $obj1[0]->name . "</p>";
	}
?>