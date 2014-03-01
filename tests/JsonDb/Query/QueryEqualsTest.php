<?php

class QueryEqualsTest extends \PHPUnit_Framework_TestCase
{
    public function testCriteria()
    {
        $dut = new \JsonDb\Query\QueryEquals('foo', 'bar');

        $this->assertTrue($dut->match(array('foo' => 'bar')));
        $this->assertFalse($dut->match(array('foo' => '...')));
        $this->assertFalse($dut->match(array('...' => 'bar')));
    }
}