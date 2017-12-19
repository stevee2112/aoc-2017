<?php

$steps = 3;

$spinlock = [
	'at' => 0,
	'buffer' => [0],
];

$steps = 329;

for ($i = 1; $i <= 2017; $i++) {
	$spinlock = spin($spinlock, $i, $steps);
}

echo $spinlock['buffer'][$spinlock['at'] + 1] . "\n";

function spin($spinlock, $insert, $steps) {

	$spinlock['at'] = (($spinlock['at'] + $steps) % $insert) + 1;

	array_splice($spinlock['buffer'], $spinlock['at'], 0, $insert);
	
	return $spinlock;
}
