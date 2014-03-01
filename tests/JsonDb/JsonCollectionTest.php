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
        $test = array('foo' => 'bar');
        $test2= array('aze' => 'rty');

        $dut = new \JsonDb\JsonCollection($this->testPath);
        $dut->insert($test);
        $dut->insert($test2);

        $data = $dut->find(\JsonDb\Query\Query::equals('aze', 'rty'));

        $this->assertTrue(is_array($data));
        $this->assertEquals(1, count($data));
        $this->assertContains('aze', array_keys($data[0]));
    }

    function testDeleteWithoutCondition()
    {
        $test = array('foo' => 'bar');
        $test2= array('aze' => 'rty');

        $dut = new \JsonDb\JsonCollection($this->testPath);
        $dut->insert($test);
        $dut->insert($test2);

        $dut->delete();
        $data = $dut->find();

        $this->assertTrue(is_array($data));
        $this->assertEquals(0, count($data));
    }

    function testDelete()
    {
        $test = array('foo' => 'bar');
        $test2= array('aze' => 'rty');

        $dut = new \JsonDb\JsonCollection($this->testPath);
        $dut->insert($test);
        $dut->insert($test2);

        $dut->delete(\JsonDb\Query\Query::equals('aze', 'rty'));
        $data = $dut->find(\JsonDb\Query\Query::equals('aze', 'rty'));

        $this->assertTrue(is_array($data));
        $this->assertEquals(0, count($data));
    }

    function testUpdateWithoutCondition()
    {
        $test = array('foo' => 'bar');
        $test2= array('aze' => 'rty');

        $dut = new \JsonDb\JsonCollection($this->testPath);
        $dut->insert($test);
        $dut->insert($test2);

        $dut->update(null, array('aze' => 'grr'));
        $data = $dut->find();

        $this->assertContains('aze', array_keys($data[0]));
        $this->assertSame('grr', $data[0]['aze']);
        $this->assertContains('aze', array_keys($data[1]));
        $this->assertSame('grr', $data[1]['aze']);
    }

    function testUpdate()
    {
        $test = array('foo' => 'bar');
        $test2= array('aze' => 'rty');

        $dut = new \JsonDb\JsonCollection($this->testPath);
        $dut->insert($test);
        $dut->insert($test2);

        $dut->update(\JsonDb\Query\Query::equals('aze', 'rty'), array('aze' => 'grr'));
        $data = $dut->find(\JsonDb\Query\Query::equals('aze', 'grr'));

        $this->assertTrue(is_array($data));
        $this->assertEquals(1, count($data));
        $this->assertContains('aze', array_keys($data[0]));
    }

    function testFlush()
    {
        $test = array('foo' => 'bar');
        $test2= array('aze' => 'rty');

        $collection = new \JsonDb\JsonCollection($this->testPath);
        $collection->insert($test);
        $collection->insert($test2);
        $collection->flush();

        $dut = new \JsonDb\JsonCollection($this->testPath);
        $data = $dut->find();

        $this->assertTrue(is_array($data));
        $this->assertEquals(2, count($data));
    }
}