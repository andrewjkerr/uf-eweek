<?php
	$json = file_get_contents('http://localhost/~andrewjkerr/eweek/get_societies.php');
	$obj = json_decode($json);
	foreach($obj as $i){
		echo "<p>" . $i->id . ": " . $i->name . "</p>";
	}
	echo "-------------------------------";
	$url = "http://localhost/~andrewjkerr/eweek/get_societies.php";
	$json1 = file_get_contents($url);
	$obj1 = json_decode($json1);
	for($j = 0; $j < 3; $j++){
		echo "<p>" . $obj1[$j]->id . ": " . $obj1[$j]->name . "</p>";
	}
?>

