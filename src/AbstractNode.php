<?php

namespace AStar;

abstract class AbstractNode implements Node
{
    private $parent;
    private $children = [];
    private $gScore;
    private $hScore;

    /**
     * @param Node $parent
     */
    public function setParent(Node $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Node
     */
    public function getParent(): Node
    {
        return $this->parent;
    }

    /**
     * @deprecated
     *
     * @param Node $child
     */
    public function addChild(Node $child)
    {
        $child->setParent($this);

        $this->children[] = $child;
    }

    /**
     * @deprecated
     * @return Node[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return float|int
     */
    public function getF(): float
    {
        return $this->getG() + $this->getH();
    }

    /**
     * @param float|int $score
     */
    public function setG($score)
    {
        if (!is_numeric($score)) {
            throw new \InvalidArgumentException('The G value is not a number');
        }

        $this->gScore = $score;
    }

    /**
     * @return float
     */
    public function getG(): float
    {
        return $this->gScore;
    }

    /**
     * @param float|int $score
     */
    public function setH($score)
    {
        if (!is_numeric($score)) {
            throw new \InvalidArgumentException('The H value is not a number');
        }

        $this->hScore = $score;
    }

    /**
     * @return float
     */
    public function getH(): float
    {
        return $this->hScore;
    }
}
