<?php

$input = trim(file_get_contents("input"));

$region_map = [
	'count' => 0,
	'map' => [],
];


for ($i = 0; $i < 128; $i++) {
	$binary = hexToBinary(knotHash("$input-$i"));
	$region_map = getRegion($i, $binary, $region_map);
}

echo countRegions($region_map['map']) . "\n";

function countRegions($map) {

	$region_index = [];

	foreach ($map as $row) {
		foreach ($row as $index => $region) {
			$region_index[$region] = null;
		}
	}

	return count($region_index) - 1; // zero does not count
}

function getRegion($row_index, $row, $region_data) {

	$row = str_split($row);

	$previous = 0;

	foreach ($row as $index => $bit) {

		if ($bit == 1 && $previous == 0) {
			$region_data['count']++;
			$region_data['map'][$row_index][$index] = $region_data['count'];
		}

		if ($bit == 1 && $previous == 1) {
			$region_data['map'][$row_index][$index] = $region_data['count'];
		}

		if ($bit == 1 && isset($region_data['map'][$row_index - 1][$index]) && $region_data['map'][$row_index - 1][$index] != 0 && $region_data['map'][$row_index - 1][$index] != $region_data['count']) {
			$region_data['map'] = remap($region_data['map'], $region_data['map'][$row_index - 1][$index], $region_data['count']);
		}

		if ($bit == 0) {
			$region_data['map'][$row_index][$index] = 0;
		}
		

		$previous = $bit;
	}
	
	return $region_data;
}

function remap($map, $old, $new) {

	foreach ($map as &$row) {
		foreach ($row as $index => $group) {

			if ($group == $old) {
				$row[$index] = $new;
			}
		}
	}

	return $map;
}

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


