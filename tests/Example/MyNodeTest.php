<?php

namespace JMGQ\AStar\Tests\Example;

use JMGQ\AStar\Example\MyNode;

class MyNodeTest extends \PHPUnit_Framework_TestCase
{
    public function validPointProvider()
    {
        return array(
            array(3, 4),
            array(0, 3),
            array('1', '2'),
            array('2', 2),
            array(0, PHP_INT_MAX)
        );
    }

    public function invalidPointProvider()
    {
        return array(
            array(-1, 3),
            array(2, -8),
            array(2.3, 2),
            array(4, null),
            array(null, 2),
            array('a', 2),
            array(array(), false)
        );
    }

    public function testShouldImplementTheNodeInterface()
    {
        $sut = new MyNode(0, 0);

        $this->assertInstanceOf('JMGQ\AStar\Node', $sut);
    }

    /**
     * @dataProvider validPointProvider
     */
    public function testShouldSetValidPoint($row, $column)
    {
        $expectedRow = (int) $row;
        $expectedColumn = (int) $column;

        $sut = new MyNode($row, $column);

        $this->assertSame($expectedRow, $sut->getRow());
        $this->assertSame($expectedColumn, $sut->getColumn());
    }

    /**
     * @dataProvider invalidPointProvider
     * @expectedException \InvalidArgumentException
     */
    public function testShouldNotSetInvalidPoint($row, $column)
    {
        new MyNode($row, $column);
    }

    /**
     * @dataProvider validPointProvider
     */
    public function testShouldGenerateAnID($row, $column)
    {
        $expectedID = $row . 'x' . $column;

        $sut = new MyNode($row, $column);

        $this->assertSame($expectedID, $sut->getID());
    }
}
