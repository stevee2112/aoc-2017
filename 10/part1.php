<?php

$input = trim(file_get_contents("input"));

$list = range(0,255);
$lengths = explode(",", $input);

$at = 0;
$skip_size = 0;

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

echo (($list[0] * $list[1]) . "\n");