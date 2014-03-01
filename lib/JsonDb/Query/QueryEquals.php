<?php

namespace JsonDb\Query;

class QueryEquals extends Query implements QueryInterface
{
    private $field;
    private $value;

    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $document)
    {
        return isset($document[$this->field]) &&
            $document[$this->field] == $this->value;
    }
}