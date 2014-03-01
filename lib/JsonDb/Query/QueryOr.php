<?php

namespace JsonDb\Query;

class QueryOr implements QueryInterface
{
    private $a, $b;

    public function __construct($a, $b)
    {
        $this->a = $a; $this->b = $b;
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $document)
    {
        return $this->a->match($document) || $this->b->match($document);
    }
}