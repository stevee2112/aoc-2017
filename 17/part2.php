<?php

$rotations = (int) $argv[1];

$spinlock = [
	'at' => 0,
	'after_zero' => 0,
];

$steps = 329;

for ($i = 1; $i <= $rotations; $i++) {
	$spinlock = spin($spinlock, $i, $steps);
}

echo $spinlock['after_zero'] . "\n";

function spin($spinlock, $insert, $steps) {

	$spinlock['at'] = (($spinlock['at'] + $steps) % $insert) + 1;

	if ($spinlock['at'] == 1) {
		$spinlock['after_zero'] = $insert;
	}
	
	return $spinlock;
}
