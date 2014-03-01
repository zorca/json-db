<?php

namespace JsonDb\Operation;

use JsonDb\Query\QueryAny;
use JsonDb\Query\QueryInterface;

class Update implements OperationInterface
{
    protected $query;
    protected $value;

    public function __construct(QueryInterface $query = null, $value)
    {
        if(is_null($query)){
            $query = new QueryAny(true); // match all
        }
        $this->query = $query;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(array &$collection)
    {
        $copy = $collection;
        foreach($copy as $key => $document){
            if($this->query->match($document)){
                $collection[$key] = array_merge($collection[$key], $this->value);
            }
        }
    }
}