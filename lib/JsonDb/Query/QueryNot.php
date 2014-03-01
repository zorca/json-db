<?php

namespace JsonDb\Query;


class QueryNot implements QueryInterface
{
    private $a, $b;

    public function __construct($a)
    {
        $this->a = $a;
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $document)
    {
        return ! $this->a->match($document);
    }
}