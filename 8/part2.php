<?php

include('Registry.php');

$input = trim(file_get_contents("input"));
$instructions = explode("\n", $input);

$registry = new Registry;

foreach ($instructions as $instruction) {

	$parts = explode("if", $instruction);

	$action = trim($parts[0]);
	$condition = trim($parts[1]);

	if ($registry->checkCondition($condition)) {
		$registry->updateRegistry($action);
	}
}

echo $registry->getMaxValueEver() . "\n";

