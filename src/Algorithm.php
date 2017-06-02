<?php

namespace AStar;

abstract class Algorithm
{
    private $openList;
    private $closedList;

    public function __construct()
    {
        $this->openList = new NodeList();
        $this->closedList = new NodeList();
    }

    /**
     * @param Node $node
     *
     * @return Node[]
     */
    abstract public function generateAdjacentNodes(Node $node): array;

    /**
     * @param Node $node
     * @param Node $adjacent
     *
     * @return int | float
     */
    abstract public function calculateRealCost(Node $node, Node $adjacent): float;

    /**
     * @param Node $start
     * @param Node $end
     *
     * @return int | float
     */
    abstract public function calculateEstimatedCost(Node $start, Node $end): float;

    /**
     * @return NodeList
     */
    public function getOpenList(): NodeList
    {
        return $this->openList;
    }

    /**
     * @return NodeList
     */
    public function getClosedList(): NodeList
    {
        return $this->closedList;
    }

    /**
     * Sets the algorithm to its initial state.
     */
    public function clear(): void
    {
        $this->getOpenList()->clear();
        $this->getClosedList()->clear();
    }

    /**
     * @param Node $start
     * @param Node $goal
     *
     * @return Node[]
     */
    public function run(Node $start, Node $goal): array
    {
        $path = [];

        $this->clear();

        $start->setG(0);
        $start->setH($this->calculateEstimatedCost($start, $goal));

        $this->getOpenList()->add($start);

        while (!$this->getOpenList()->isEmpty()) {
            $currentNode = $this->getOpenList()->extractBest();

            $this->getClosedList()->add($currentNode);

            if ($currentNode->getID() === $goal->getID()) {
                $path = $this->generatePathFromStartNodeTo($currentNode);
                break;
            }

            $successors = $this->computeAdjacentNodes($currentNode, $goal);

            foreach ($successors as $successor) {
                if ($this->getOpenList()->contains($successor)) {
                    $successorInOpenList = $this->getOpenList()->get($successor);

                    if ($successor->getG() >= $successorInOpenList->getG()) {
                        continue;
                    }
                }

                if ($this->getClosedList()->contains($successor)) {
                    $successorInClosedList = $this->getClosedList()->get($successor);

                    if ($successor->getG() >= $successorInClosedList->getG()) {
                        continue;
                    }
                }

                $successor->setParent($currentNode);

                $this->getClosedList()->remove($successor);

                $this->getOpenList()->add($successor);
            }
        }

        return $path;
    }

    /**
     * @param Node $node
     *
     * @return array
     */
    private function generatePathFromStartNodeTo(Node $node): array
    {
        $path = [];

        $currentNode = $node;

        while ($currentNode !== null) {
            array_unshift($path, $currentNode);

            $currentNode = $currentNode->getParent();
        }

        return $path;
    }

    /**
     * @param Node $node
     * @param Node $goal
     *
     * @return array|Node[]
     */
    private function computeAdjacentNodes(Node $node, Node $goal): array
    {
        $nodes = $this->generateAdjacentNodes($node);

        foreach ($nodes as $adjacentNode) {
            $adjacentNode->setG($node->getG() + $this->calculateRealCost($node, $adjacentNode));
            $adjacentNode->setH($this->calculateEstimatedCost($adjacentNode, $goal));
        }

        return $nodes;
    }
}
