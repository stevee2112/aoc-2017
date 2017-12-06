<?php

$input = trim(file_get_contents('input'));

$seq = explode("\n", $input);

$at = 0;
$jumps = 0;
$escaped = false;

while (!$escaped)
{
	$current_at = $at;

	// Move
	$at += $seq[$at];

	// Increment previous at
	$seq[$current_at]++;

	// Increment jump counter
	$jumps++;

	//check if out
	if ($at >= count($seq))
	{
		$escaped = true;
	}
	
}

echo "$jumps\n";