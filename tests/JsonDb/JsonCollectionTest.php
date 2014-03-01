<?php

class JsonCollectionTest extends \PHPUnit_Framework_TestCase
{
    protected $testPath;

    function setUp()
    {
        $this->testPath = sys_get_temp_dir() . '/test.json';
    }

    function tearDown()
    {
        if(file_exists($this->testPath)){
            unlink($this->testPath);
        }
    }

    /**
     * Unknown path return exception
     */
    function testNotExistingPathException()
    {
        $this->setExpectedException('\Exception');
        new \JsonDb\JsonCollection('this/path/does/not/exists');
    }

    /**
     * Construction is ok
     */
    function testConstructAndDrop()
    {
        // Lets create a collection...
        $dut = new \JsonDb\JsonCollection($this->testPath);
        $this->assertTrue(file_exists($this->testPath));

        // ... and drop it
        $dut->drop();
        $this->assertFalse(file_exists($this->testPath));
    }

    /**
     * Insertion is ok
     */
    function testInsert()
    {
        $dut = new \JsonDb\JsonCollection($this->testPath);

        // Insert data...
        $data = array('foo' => 'bar');
        $dut->insert($data);

        $this->assertTrue(isset($data['_id']), 'Got no new Id');

        unset($dut);
    }

    /**
     * @depends testInsert
     */
    function testFindWithoutCondition()
    {
        $test = array('foo' => 'bar');

        $dut = new \JsonDb\JsonCollection($this->testPath);
        $dut->insert($test);

        $data = $dut->find();

        $this->assertTrue(is_array($data));
        $this->assertEquals(1, count($data));
        $this->assertContains('foo', array_keys($data[0]));
    }

    /**
     * @depends testInsert
     */
    function testFind()
    {
        $this->markTestIncomplete('Shall implement');
    }

    function testDeleteWithoutCondition()
    {
        $this->markTestIncomplete('Shall implement');
    }

    function testDelete()
    {
        $this->markTestIncomplete('Shall implement');
    }

    function testUpdateWithoutCondition()
    {
        $this->markTestIncomplete('Shall implement');
    }

    function testUpdate()
    {
        $this->markTestIncomplete('Shall implement');
    }
}