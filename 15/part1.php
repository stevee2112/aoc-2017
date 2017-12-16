<?php

$prev_a = 65;
$prev_b = 8921;

$factor_a = 16807;
$factor_b = 48271;

$matches = 0;

for ($i = 0; $i < 1000000; $i++) {

	$prev_a = generateValue($prev_a, $factor_a, 2147483647);
	$a_bits = substr(decbin((int) $prev_a), -16);

	$prev_b = generateValue($prev_b, $factor_b, 2147483647);
	$b_bits = substr(decbin((int) $prev_b), -16);

	if ($a_bits === $b_bits) {
		$matches++;
	}
}

echo $matches . "\n";

function generateValue($value, $factor, $divisor) {
	return bcmod(bcmul($value, $factor), $divisor);
}