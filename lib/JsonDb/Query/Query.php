<?php

namespace JsonDb\Query;

class Query implements QueryInterface
{
    public function __call($name, $arguments)
    {
        switch($name){
            case 'and':
                return new QueryAnd($this, $arguments[0]);
                break;
            case 'or':
                return new QueryOr($this, $arguments[0]);
                break;
            case 'not':
                return new QueryNot($this);
                break;
        }
        throw new \Exception('unsupported method');
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $document)
    {
        throw new \Exception('Please add some criterias.');
    }

    static public function equals($field, $value)
    {
        return new QueryEquals($field, $value);
    }
}