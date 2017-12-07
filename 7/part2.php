<?php

include("vendor/autoload.php");
include("SearchVisitor.php");
include("BalanceVisitor.php");

use Tree\Node\Node;

$input = trim(file_get_contents("input"));

$programs = explode("\n", $input);

$root = new Node([
	'name' => 'root'
]);

$searcher = new \SearchVisitor();	

foreach ($programs as $program) {

	$parts = explode(" ", $program);

	$name = $parts[0];
	$weight = trim($parts[1], "()");

	// Check if we already know about this program
	$searcher->setSearchValue($name);
	$nodes = $root->accept($searcher);

	if (!empty($nodes)) {
		$program_node = $nodes[0];
		$new_value = $program_node->getValue();
		$new_value['weight'] = $weight;
		$program_node->setValue($new_value);
	} else {
		$program_node = new Node([
			'name' => $name,
			'weight' => (int) $weight
		]);
		$root->addChild($program_node);
	}

	// Check for children
	$child_str = explode("->", $program);

	if (isset($child_str[1])) {
		$children = explode(",", $child_str[1]);

		foreach ($children as $child) {
			$child = trim($child);

			$searcher->setSearchValue($child);

			$nodes = $root->accept($searcher);

			if (!empty($nodes)) {
				$child_node = $nodes[0];
				$child_node->getParent()->removeChild($child_node); // <---- DUMB
			} else {
				$child_node = new Node([
					'name' => $child
				]);
			}

			$program_node->addChild($child_node);
		}
	}	
}

$balancer = new \BalanceVisitor();
$root_prog = $root->getChildren()[0];

$root_prog->accept($balancer);
$balanced_node = $balancer->getBalancedNode();
echo $balanced_node->getValue()['weight'] . "\n";
