<?php

$input = trim(file_get_contents("input"));
$directions = explode(",", $input);

$x = 0;  // n,s
$y = 0; // ne,sw 
$z = 0; // nw,se

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
}

echo ((abs($x) + abs($y) + abs($z)) / 2) . "\n";
