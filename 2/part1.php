<?php

$rowInput = explode("\n", trim(file_get_contents('input')));

$checkSum = 0;

foreach ($rowInput as $row) {
	$numbers = explode("\t", $row);

	$max = max($numbers);
	$min = min($numbers);

	$checkSum += $max - $min;
}

echo "$checkSum\n";
