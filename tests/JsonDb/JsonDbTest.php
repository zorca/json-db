<?php

class JsonDbTest extends \PHPUnit_Framework_TestCase
{
    function testNotExistingPathException()
    {
        $this->setExpectedException('\JsonDb\JsonDbException');
        $dut = new \JsonDb\JsonDb('this/path/does/not/exists');
    }

    function testNotWriteablePathException()
    {
        $this->setExpectedException('\JsonDb\JsonDbException');
        $dut = new \JsonDb\JsonDb('/');
    }

    function testConstructOk()
    {
        $dut = new \JsonDb\JsonDb(sys_get_temp_dir());
        $this->assertTrue(is_object($dut));
    }

    function testGetCollection()
    {
        $dut = new \JsonDb\JsonDb(sys_get_temp_dir());
        $collection = $dut->getCollection('test');
        $this->assertTrue(is_object($dut));
    }
}