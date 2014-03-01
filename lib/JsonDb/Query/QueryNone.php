<?php

namespace JsonDb\Query;

class QueryNone extends Query implements QueryInterface
{
    /**
     * {@inheritdoc}
     */
    public function match(array $document)
    {
        return false;
    }
}