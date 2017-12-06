<?php

$input = trim(file_get_contents('input'));

$passphrases = explode("\n", $input);
$invalid = 0;

foreach ($passphrases as $passphrase) {

	$char_counts_all = [];

	$words = explode(" ", $passphrase);

	if ((count(array_unique($words)) != count($words))) {
		$invalid++;
		continue;
	}
	
	foreach ($words as $word) {
		$char_counts = array_count_values(str_split($word));

		foreach ($char_counts_all as $key => $char_counts_prev) {

			if (empty(array_merge(array_diff_assoc($char_counts, $char_counts_prev), array_diff_assoc($char_counts_prev, $char_counts)))) {

				$invalid++;
				continue(3);
			}
		}

		$char_counts_all[$word] = $char_counts;
	}
	
}

echo count($passphrases) - $invalid . "\n";
