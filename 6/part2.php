<?php

$input = trim(file_get_contents("input"));

$memory = explode("\t", $input);

$match = FALSE;
$first = TRUE;
$counter = 0;
$blocks_seen = [];

while($match == FALSE) {
	$max_index = array_search(max($memory),$memory);
	$max = $memory[$max_index];

	$memory[$max_index] = 0;

	$at = $max_index;
	
	while ($max > 0) {

		// Get next index
		$at = (isset($memory[$at + 1])) ? ($at + 1) : 0;

		// Increment memory index
		$memory[$at]++;

		// Decrement max
		$max--;
	}

	// Increment counter
	$counter++;

	$block_string = implode("", $memory);
	
	if (isset($blocks_seen[$block_string])) {
		// Reset counter

		if ($first) {
			$blocks_seen = [];
			$counter = 0;
			$first = FALSE;
		} else {
			$match = TRUE;
			break;
		}
	}

	// store block configuration
	$blocks_seen[implode("", $memory)] = 1;
}

echo "$counter\n";
