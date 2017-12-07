<?php
/**
 * This file is part of Tree
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

use Tree\Visitor\Visitor;
use Tree\Node\NodeInterface;

/**
 * Class YieldVisitor
 *
 * @package Tree\Visitor
 */
class BalanceVisitor implements Visitor
{
	protected $balanced_node;

    /**
     * {@inheritdoc}
     */
    public function visit(NodeInterface $node)
    {
		$sum = 0;

		$children = $node->getChildren();
		$child_count = count($children);

		$child_sums = [];
		
        foreach ($children as $child) {
            $child_sum = $child->accept($this);

			$child_sums[] = $child_sum;

			$sum += $child_sum;
        }

		if (!empty($child_sums)) {

			// Uneven
			if (count(array_unique($child_sums)) > 1) {

				// Get bad value
				$bad_value = null;
				foreach (array_count_values($child_sums) as $value => $times) {
					if ($times == 1) {
						$bad_value = $value;
						break;
					}
				}

				// Get goodvalue
				$good_value = null;
				foreach (array_count_values($child_sums) as $value => $times) {
					if ($value != $bad_value) {
						$good_value = $value;
						break;
					}
				}

				// get child index of bad value
				foreach($child_sums as $index => $child_sum) {
					if ($child_sum == $bad_value) {
						$bad_child_at = $index;
					}
				}

				$balance_value = $good_value - $bad_value;

				// Update child weight
				$new_val = $children[0]->getValue();
				$new_val['weight'] = $new_val['weight'] + $balance_value;
				$children[0]->setValue($new_val);
				$this->balanced_node = $children[0];

				// and update sum so we see the balance
				$sum += $balance_value;
			}
		}

		$sum += $node->getValue()['weight'];
		
        return $sum;
    }

	public function getBalancedNode() {
		return $this->balanced_node;
	}
} 