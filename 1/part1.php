<?php

$input = str_split(file_get_contents('input'));

$first_num = $input[0];

$sum = 0;

while (!empty($input)) {
	$num = array_shift($input);

	if (empty($input)) {
		if ($num == $first_num)
		{
			$sum += $num;
		}
	} else {	
		if ($num == $input[0]) {
			$sum += $num;
		}
	}
}

echo "$sum\n";
