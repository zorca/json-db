<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 23/11/13
 * Time: 09:44
 * To change this template use File | Settings | File Templates.
 */

class FilterBuilderTest extends \PHPUnit_Framework_TestCase
{
    function testSimpleMatch()
    {
        $condition = array(
            'foo' => 'bar'
        );
        $dut = new \JsonDb\Filter\FilterBuilder($condition);

        $this->assertTrue($dut->match(array('foo' => 'bar')));
        $this->assertFalse($dut->match(array('yay' => 'bar')));
        $this->assertFalse($dut->match(array('foo' => 'yay')));
    }

    function testAdvancedMatch()
    {
        $condition = array(
            'foo' => 'bar',
            'aze' => 'rty'
        );

        $dut = new \JsonDb\Filter\FilterBuilder($condition);

        $this->assertFalse($dut->match(array('foo' => 'bar', 'aze' => 'yay')));
        $this->assertTrue($dut->match($condition));
    }
}