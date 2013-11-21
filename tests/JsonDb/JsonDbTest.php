<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 17/11/13
 * Time: 00:17
 * To change this template use File | Settings | File Templates.
 */

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