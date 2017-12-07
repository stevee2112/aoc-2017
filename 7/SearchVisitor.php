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
class SearchVisitor implements Visitor
{
	protected $search_value;

    /**
     * {@inheritdoc}
     */
    public function visit(NodeInterface $node)
    {
        $yield = [];

		if ($node->getValue()['name'] == $this->search_value) {
			$yield[] = $node;
		}

        foreach ($node->getChildren() as $child) {
            $yield = array_merge($yield, $child->accept($this));
        }

        return $yield;
    }

	public function setSearchValue($search_value) {
		$this->search_value = $search_value;
	}
} 