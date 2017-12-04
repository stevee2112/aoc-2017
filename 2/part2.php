<?php

$rowInput = explode("\n", trim(file_get_contents('input')));

$checkSum = 0;

foreach ($rowInput as $row) {
	$numbers = explode("\t", $row);

	$size = count($numbers);

	for ($i = 0; $i < ($size - 1); $i++) {
		for ($j = ($i + 1);$j < $size;$j++) {
			$max = max($numbers[$i], $numbers[$j]);
			$min = min($numbers[$i], $numbers[$j]);

			if (($max % $min) == 0) {
				$checkSum += ($max / $min);
				continue(3);
			}
		}
	}
}

echo "$checkSum\n";
