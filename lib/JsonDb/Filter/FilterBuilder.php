<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 23/11/13
 * Time: 09:43
 * To change this template use File | Settings | File Templates.
 */

namespace JsonDb\Filter;

/**
 * Class FilterBuilder
 * @todo Could be a Strategy
 * @package JsonDb\Filter
 */
class FilterBuilder
{
    protected $condition;
    /**
     * Supports only simple condition like And arrays.
     *
     * @param $condition
     */
    public function __construct(array $condition)
    {
        $this->condition = $condition;
    }

    /**
     * @param $data
     * @return bool True if match, false if not.
     */
    public function match($data)
    {
        foreach ($this->condition as $key => $value) {
            if(
                (! isset($data[$key])) // got the key ?
                ||
                ($data[$key] != $value) // got the correct value ?
            ){
                return false;
            }
        }

        return true;
    }

}
