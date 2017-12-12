<?php

$input = str_replace(" ", "", trim(file_get_contents("input")));
$program_list = explode("\n", $input);

$prog_network = [];

foreach ($program_list as $program_data) {

	$parts = explode("<->", $program_data);

	$program = $parts[0];

	$com_programs = explode(",", $parts[1]);

	foreach ($com_programs as $com_program) {
		$prog_network[$program][] = $com_program;
	}
}

$visited = visit(0, $prog_network, []);
print count($visited) . "\n";

function visit($program, $prog_network, $visited = []) {

	$visited[$program] = null;
	
	foreach ($prog_network[$program] as $com) {
		if (!array_key_exists($com, $visited)) {
			$visited = visit($com, $prog_network, $visited);
		}
	}
	return $visited;
}
