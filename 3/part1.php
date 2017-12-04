<?php

$size['x'] = 0;
$size['y'] = 0;

$move['x'] = 1;
$move['y'] = -1;

$axis = 'x';

$at['x'] = 0;
$at['y'] = 0;

$max = $argv[1];

for ($i=2; $i <= $max;$i++) {

	// Move
	$at[$axis] += $move[$axis];

	// If moving in postive direction
	if ($move[$axis] > 0)
	{
		// check if change dir
		if (abs($at[$axis]) > $size[$axis]) {

			$size[$axis]++;

			// switch axis
			$axis = ($axis == 'x') ? 'y' : 'x';

			// change direction		
			$move[$axis] *= -1;
		}		
	} else {
		// check if change dir
		if (abs($at[$axis]) >= $size[$axis]) {

			// switch axis
			$axis = ($axis == 'x') ? 'y' : 'x';

			// change direction		
			$move[$axis] *= -1;
		}
	}
}

echo(abs($at['x']) + abs($at['y']) . "\n");
