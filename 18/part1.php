<?php

include('MusicRegistry.php');

$input = trim(file_get_contents("input"));

$instructions = [
	'at' => 0,
	'instructions' => explode("\n", $input),
];

$registry = new MusicRegistry($instructions);
$registry->run();

echo $registry->last_played . "\n";