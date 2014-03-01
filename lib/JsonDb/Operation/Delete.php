<?php

namespace JsonDb\Operation;

use JsonDb\Query\QueryDummy;
use JsonDb\Query\QueryInterface;

class Delete implements OperationInterface
{
    protected $query;

    public function __construct(QueryInterface $query = null)
    {
        if(is_null($query)){
            $query = new QueryDummy(true); // match all
        }
        $this->query = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(array &$collection)
    {
        $copy = $collection;
        foreach($copy as $key => $document){
            if($this->query->match($document)){
                unset($collection[$key]);
            }
        }
    }
}