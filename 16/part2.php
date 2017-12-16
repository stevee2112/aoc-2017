<?php

$input = str_replace(" ", "", trim(file_get_contents("input")));
$program_instructions = explode(",", $input);

$programs = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p'];

$stages = [];
$at = 0;

while (true) {

$stages[$at] = implode("", $programs);

	foreach ($program_instructions as $move) {

		$action = substr($move,0,1);
		$params = explode("/",substr($move,1));

		switch ($action) {
			case 's':
				$programs = spin($programs, $params[0]);
				break;
			case 'x':
				$programs = exchange($programs, $params[0], $params[1]);
				break;
			case 'p':
				$programs = partner($programs, $params[0], $params[1]);
				break;
		}
	}

	$at++;

	if ( implode("", $programs) == "abcdefghijklmnop") {
		break;
	}
}

$stage = 1000000000 % count($stages);
echo $stages[$stage] . "\n";


function partner($programs, $prog1, $prog2) {

	$pos1 = array_search($prog1, $programs);
	$pos2 = array_search($prog2, $programs);

	return exchange($programs, $pos1, $pos2);
}

function exchange($programs, $pos1, $pos2) {

	$prog1 = $programs[$pos1];
	$prog2 = $programs[$pos2];

	$programs[$pos1] = $prog2;
	$programs[$pos2] = $prog1;

	return $programs;
}

function spin($programs, $count)
{
	while ($count > 0) {
		$program = array_pop($programs);
		array_unshift($programs, $program);
		$count--;
	}
	
	return $programs;
}

