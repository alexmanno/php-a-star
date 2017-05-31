<?php

namespace AStar\Tests;

class AStarTest extends BaseAStarTest
{
    public function setUp()
    {
        $this->sut = $this->getMockForAbstractClass('AStar\AStar');
    }
}
