<?php

namespace AStar\Tests;

class AlgorithmTest extends BaseAStarTest
{
    public function setUp()
    {
        $this->sut = $this->getMockForAbstractClass('AStar\Algorithm');
    }

    public function testOpenListShouldBeANodeList()
    {
        $this->assertInstanceOf('AStar\NodeList', $this->sut->getOpenList());
    }

    public function testClosedListShouldBeANodeList()
    {
        $this->assertInstanceOf('AStar\NodeList', $this->sut->getClosedList());
    }

    public function testShouldResetToCleanState()
    {
        $node = $this->getMock('AStar\Node');
        $node->expects($this->any())
            ->method('getID')
            ->will($this->returnValue('someUniqueID'));

        $this->sut->getOpenList()->add($node);
        $this->sut->getClosedList()->add($node);

        $this->assertCount(1, $this->sut->getOpenList());
        $this->assertCount(1, $this->sut->getClosedList());

        $this->sut->clear();

        $this->assertCount(0, $this->sut->getOpenList());
        $this->assertCount(0, $this->sut->getClosedList());
    }
}
