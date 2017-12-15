<?php

$input = str_replace(" ", "", trim(file_get_contents("input")));
$layers = explode("\n", $input);

$firewall = buildFirewall($layers);

$severity = 0;


$max_depth = max(array_keys($firewall));

for ($i = 0; $i <= $max_depth; $i++) {

	if (isset($firewall[$i]) && $firewall[$i]['at'] == 0) {
		$severity += ($i * $firewall[$i]['range']);
	}

	$firewall = advance($firewall);
}

echo $severity . "\n";


function buildFirewall($layers) {

	$firewall = [];

	foreach ($layers as $layer) {
		$parts = explode(":", $layer);

		$firewall[$parts[0]] = [
			'at' => 0,
			'range' => $parts[1],
			'direction' => 1,
		];
	}

	return $firewall;
}

function advance($firewall) {

	foreach ($firewall as &$layer) {

		if ( $layer['direction'] == 1) {
 			if (($layer['at'] + 1) == $layer['range']) { // Reverse direction
				$layer['at']--;
				$layer['direction'] = -1;
			} else {
				$layer['at']++;
			}
		} else {
 			if (($layer['at'] - 1) < 0) { // Reverse direction
				$layer['at']++;
				$layer['direction'] = 1;
			} else {
				$layer['at']--;
			}
			
		}
	}

	return $firewall;
}