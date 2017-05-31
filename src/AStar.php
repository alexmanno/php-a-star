<?php

namespace AStar;

abstract class AStar
{
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
     * @param Node $start
     * @param Node $goal
     *
     * @return Node[]
     */
    public function run(Node $start, Node $goal): array
    {
        $algorithm = new CallbackAlgorithm(
            $this,
            'generateAdjacentNodes',
            'calculateRealCost',
            'calculateEstimatedCost'
        );

        return $algorithm->run($start, $goal);
    }
}
