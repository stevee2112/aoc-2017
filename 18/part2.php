<?php

include('ProgramRegistry.php');

$input = trim(file_get_contents("input"));

$instructions = [
	'at' => 0,
	'instructions' => explode("\n", $input),
];

$programs[0] = new ProgramRegistry(0, $instructions);
$programs[1] = new ProgramRegistry(1, $instructions);
$programs[0]->setOtherProgram($programs[1]);
$programs[1]->setOtherProgram($programs[0]);

$deadlocked = false;

$at = 0;

while (!$deadlocked && (!$programs[0]->finished || !$programs[1]->finished)) {


	$programs[$at]->run();
	if (($programs[$at]->is_waiting && empty($programs[$at]->queue)) &&
		($programs[1 - $at]->is_waiting && empty($programs[1 - $at]->queue))) {
		break;
	}

	$at = 1 - $at;

}

echo $programs[1]->send_count . "\n";
