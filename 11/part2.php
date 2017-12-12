<?php

$input = trim(file_get_contents("input"));
$directions = explode(",", $input);

$x = 0;  // n,s
$y = 0; // ne,sw 
$z = 0; // nw,se

$max_distance = 0;

foreach ($directions as $direction) {

	switch ($direction) {
		case 'n' :
			$y++;
			$z--;
			break;
		case 's' :
			$y--;
			$z++;
			break;
		case 'ne' :
			$x++;
			$z--;
			break;
		case 'sw' :
			$x--;
			$z++;
			break;
		case 'nw' :
			$y++;
			$x--;
			break;
		case 'se' :
			$y--;
			$x++;
			break;
		
	}

	$distance = ((abs($x) + abs($y) + abs($z)) / 2);

	if ($distance > $max_distance) {
		$max_distance = $distance;
	}
}

echo $max_distance . "\n";
