<?php

namespace JsonDb\Operation;

class Delete implements OperationInterface
{
    protected $query;
    protected $value;

    public function __construct(QueryInterface $query, $value)
    {
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
                unset($collection[$key]);
            }
        }
    }
}