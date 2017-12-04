<?php

$size['x'] = 0;
$size['y'] = 0;

$move['x'] = 1;
$move['y'] = -1;

$axis = 'x';

$at['x'] = 0;
$at['y'] = 0;

$values = [];
$values[0][0] = 1;

$max = $argv[1];

for ($i=2; $i <= $max;$i++) {

	// Move
	$at[$axis] += $move[$axis];

	$value = getValue($values, $at['x'], $at['y']);		
	$values[$at['x']][$at['y']] = $value;

	if ($value > $max)
	{
		break;
	}
	
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

function getValue($values, $x, $y) {

	$adjacent[] = isset($values[$x - 1][$y - 1]) ? $values[$x - 1][$y - 1] : 0;
	$adjacent[] = isset($values[$x - 1][$y]) ? $values[$x - 1][$y] : 0;
	$adjacent[] = isset($values[$x - 1][$y + 1]) ? $values[$x - 1][$y + 1] : 0;
	$adjacent[] = isset($values[$x + 1][$y - 1]) ? $values[$x + 1][$y - 1] : 0;
	$adjacent[] = isset($values[$x + 1][$y]) ? $values[$x + 1][$y] : 0;
	$adjacent[] = isset($values[$x + 1][$y + 1]) ? $values[$x + 1][$y + 1] : 0;
	$adjacent[] = isset($values[$x][$y + 1]) ? $values[$x][$y + 1] : 0;
	$adjacent[] = isset($values[$x][$y - 1]) ? $values[$x][$y - 1] : 0;

	return array_sum($adjacent);
}

echo($values[$at['x']][$at['y']] . "\n");

