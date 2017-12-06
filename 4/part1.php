<?php

$input = trim(file_get_contents('input'));

$passphrases = explode("\n", $input);
$matches = 0;

foreach ($passphrases as $passphrase) {
	$words = explode(" ", $passphrase);

	if ((count(array_unique($words)) == count($words))) {
		$matches++;
	}
}

echo "$matches\n";
