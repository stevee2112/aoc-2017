<?php

$input = trim(file_get_contents("input"));

$stream = str_split($input);

$stack = [];
$score = 0;
$garbage = false;

while (!empty($stream)) {

	$char = array_shift($stream);
	
	if (!$garbage) {
		switch ($char) {
			case "{" :
				array_unshift($stack, $char);
				break;
			case "}" :
				$score += count($stack);
				array_shift($stack);
				break;
			case "<" :
				$garbage = true;
				break;
		}
	} else {
		switch ($char) {
			case ">" :
				$garbage = false;
				break;
			case "!" :
				// Ignore next char				
				$ignored = array_shift($stream);
				break;
		}
	}
}

echo "$score\n";