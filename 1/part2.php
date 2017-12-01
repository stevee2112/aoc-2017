<?php

// Since the list is circular we only need to look at have the list then multiple by 2

$input = str_split(file_get_contents('input'));

$checkDistance = count($input) / 2;
$sum = 0;

for ($i = 0;$i < $checkDistance;$i++)
{
	if ($input[$i] == $input[$i + $checkDistance])
	{
		$sum += $input[$i];
	}
}

// Since circular
$sum = $sum * 2;

echo "$sum\n";
