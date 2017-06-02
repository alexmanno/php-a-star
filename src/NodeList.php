<?php

namespace AStar;

use ArrayIterator;

class NodeList implements \IteratorAggregate
{
    private $nodeList = array();

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->nodeList);
    }

    /**
     * @param Node $node
     */
    public function add(Node $node)
    {
        $this->nodeList[$node->getID()] = $node;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->nodeList);
    }

    /**
     * @param Node $node
     *
     * @return bool
     */
    public function contains(Node $node): bool
    {
        return isset($this->nodeList[$node->getID()]);
    }

    /**
     * @return Node | null
     */
    public function extractBest(): ?Node
    {
        $bestNode = null;

        foreach ($this->nodeList as $node) {
            if ($bestNode === null || $node->getF() < $bestNode->getF()) {
                $bestNode = $node;
            }
        }

        if ($bestNode !== null) {
            $this->remove($bestNode);
        }

        return $bestNode;
    }

    /**
     * @param Node $node
     */
    public function remove(Node $node)
    {
        unset($this->nodeList[$node->getID()]);
    }

    /**
     * @param Node $node
     *
     * @return Node | null
     */
    public function get(Node $node): ?Node
    {
        if ($this->contains($node)) {
            return $this->nodeList[$node->getID()];
        }

        return null;
    }

    /**
     * Empties the array
     */
    public function clear()
    {
        $this->nodeList = array();
    }
}
