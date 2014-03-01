<?php

namespace JsonDb\Query;

class QueryDummy extends Query implements QueryInterface
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $document)
    {
        return $this->value;
    }
}