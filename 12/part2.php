<?php

$input = str_replace(" ", "", trim(file_get_contents("input")));
$program_list = explode("\n", $input);

$groups = [];
$group_index = 1;
$prog_network = [];
$at = 0;

foreach ($program_list as $program_data) {

	$parts = explode("<->", $program_data);

	$program = $parts[0];
	$groups[$program] = null;

	$com_programs = explode(",", $parts[1]);

	foreach ($com_programs as $com_program) {
		$prog_network[$program][] = $com_program;
	}
}


$groupless = true;

while ($groupless)
{
	$visited = visit($at, $prog_network, []);

	foreach ($visited as $key => $value) {
		$groups[$key] = $group_index;
	}

	$groupless_program = array_search(null, $groups);

	if ($groupless_program === false) {
		$groupless = false;
	} else {
		$group_index++;
		$at = $groupless_program;
	}
}

print $group_index . "\n";

function visit($program, $prog_network, $visited = []) {

	$visited[$program] = null;
	
	foreach ($prog_network[$program] as $com) {
		if (!array_key_exists($com, $visited)) {
			$visited = visit($com, $prog_network, $visited);
		}
	}
	return $visited;
}
