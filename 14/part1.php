<?php

$input = trim(file_get_contents("input"));

$used = 0;

for ($i = 0; $i < 128; $i++) {
	$binary = hexToBinary(knotHash("$input-$i"));
	$used += substr_count($binary, 1);
}

echo $used . "\n";

function hexToBinary($hex) {

	$binary = "";
	$hex_split = str_split($hex);

	foreach ($hex_split as $hex_digit) {	
		$binary .= str_pad(base_convert($hex_digit, 16, 2), 4, "0", STR_PAD_LEFT);
	}

	return $binary;
}

function knotHash($string) {

	$list = range(0,255);
	$lengths = str_split($string);

	// Convert to ascii
	$lengths = array_map(function($value) {
		return ord($value);
	}, $lengths);

	$lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

	$at = 0;
	$skip_size = 0;

	for ($i=0; $i < 64; $i++) {
		foreach ($lengths as $length) {

			$left = 0;
			// get section
			$section = array_slice($list, $at, $length);

			// check if we went past the end and get that as well
			if (count($section) != $length) {

				$left = $length - count($section);
				$section = array_merge($section, array_slice($list, 0, $left));
			}

			// Reverse the section
			$section = array_reverse($section);

			// replace it
			array_splice($list, $at, $length, $section);

			// Handle wrap
			if ($left > 0) {
				$wrap = array_splice($list, (-1 * $left));
				array_splice($list, 0, $left, $wrap);
			}	

			// update at
			$at += ($skip_size + $length);

			if ($at >= count($list)) {
				$at = $at % count($list);
			}

			$skip_size++;
		}
	}


	$hash = [];

	while (!empty($list)) {
		$block = array_splice($list,0,16);

		$hash_value = array_reduce($block, function($carry, $value) {
			$carry = $carry ^ $value;
			return $carry;
		});

		$hash[] = str_pad(dechex($hash_value), 2, "0", STR_PAD_LEFT);
	}

	return implode("", $hash);
}


