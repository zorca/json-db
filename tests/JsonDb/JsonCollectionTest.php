<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 17/11/13
 * Time: 00:27
 * To change this template use File | Settings | File Templates.
 */

class JsonCollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $testPath;

    function setUp()
    {
        $this->testPath = sys_get_temp_dir() . '/test.json';
    }

    function deleteTestFixture()
    {
        if(file_exists($this->testPath)){
            unlink($this->testPath);
        }
    }

    function testNotExistingPathException()
    {
        $this->setExpectedException('\Exception');
        $dut = new \JsonDb\JsonCollection('this/path/does/not/exists');
    }

    function testConstructAndDrop()
    {
        $this->deleteTestFixture();

        // Lets create a collection...
        $dut = new \JsonDb\JsonCollection($this->testPath);
        $this->assertTrue(file_exists($this->testPath));

        // ... and drop it
        $dut->drop();
        $this->assertFalse(file_exists($this->testPath));
    }

    function testInsert()
    {
        $dut = new \JsonDb\JsonCollection($this->testPath);

        // Insert data...
        $data = array('foo' => 'bar');
        $dut->insert($data);

        unset($dut);

        // Can we retrieve it ?
        $dut2 = new \JsonDb\JsonCollection($this->testPath);
        $data2 = $dut2->selectAll();

        $this->assertTrue(is_array($data2));
        $this->assertEquals(1, count($data2));
        $this->assertSame($data, $data2[0]);
    }
}