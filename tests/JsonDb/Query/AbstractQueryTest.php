<?php

class AbstractQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testDummy()
    {
        $dut = new \JsonDb\Query\QueryDummy(true);
        $this->assertTrue($dut->match(array()));
    }

    public function testAnd()
    {
        $false = new \JsonDb\Query\QueryDummy(false);
        $true = new \JsonDb\Query\QueryDummy(true);

        $this->assertTrue($true->and($true)->match(array()));
        $this->assertFalse($true->and($false)->match(array()));
        $this->assertFalse($false->and($false)->match(array()));
    }

    public function testOr()
    {
        $false = new \JsonDb\Query\QueryDummy(false);
        $true = new \JsonDb\Query\QueryDummy(true);

        $this->assertTrue($true->or($true)->match(array()));
        $this->assertTrue($true->or($false)->match(array()));
        $this->assertFalse($false->or($false)->match(array()));
    }

    public function testNot()
    {
        $false = new \JsonDb\Query\QueryDummy(false);
        $true = new \JsonDb\Query\QueryDummy(true);

        $this->assertFalse($true->not()->match(array()));
        $this->assertTrue($false->not()->match(array()));
    }
}