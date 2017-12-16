
use Data::Dumper;

$prev_a = 703;
$prev_b = 516;

$factor_a = 16807;
$factor_b = 48271;

$multiple_a = 4;
$multiple_b = 8;

$matches = 0;

@a_multiples = ();
@b_multiples = ();

$count = 5000000;

while ((scalar @a_multiples) < $count || (scalar @b_multiples) < $count) {

	if ((scalar @a_multiples) < $count) {

		$prev_a = generateValue($prev_a, $factor_a, $multiple_a, 2147483647);

		if ($prev_a % $multiple_a == 0) {
			push (@a_multiples, $prev_a);
		}
    }

	if ((scalar @b_multiples) < $count) {

		$prev_b = generateValue($prev_b, $factor_b, $multiple_b, 2147483647);

		if ($prev_b % $multiple_b == 0) {
			push (@b_multiples, $prev_b);
		}
    }
}

while (scalar @a_multiples > 0) {
	$a_val = shift(@a_multiples);
	$b_val = shift(@b_multiples);

	if ((substr(dec2bin($a_val ^ $b_val), -16) ^ 0) == 0 ) {
		$matches++;
	}
}

print $matches . "\n";

sub dec2bin {
	my $str = unpack("B32", pack("N", shift));
    return $str;
}

sub generateValue {

	my ($value, $factor, $multiple, $divisor) = @_;

	return ($value * $factor) % $divisor;
}
