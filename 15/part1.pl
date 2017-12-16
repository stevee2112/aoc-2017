

$prev_a = 703;
$prev_b = 516;

$factor_a = 16807;
$factor_b = 48271;

$matches = 0;

for ($i = 0; $i < 40000000; $i++) {

	
	$prev_a = generateValue($prev_a, $factor_a, 2147483647);
	
	$prev_b = generateValue($prev_b, $factor_b, 2147483647);

	
	if ((substr(dec2bin($prev_a ^ $prev_b), -16) ^ 0) == 0 ) {
		$matches++;
	}
}

print $matches . "\n";

sub dec2bin {
	my $str = unpack("B32", pack("N", shift));
    return $str;
}

sub generateValue {

	my ($value, $factor, $divisor) = @_;

	return ($value * $factor) % $divisor
}
