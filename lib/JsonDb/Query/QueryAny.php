<?php

namespace JsonDb\Query;

class QueryAny extends Query implements QueryInterface
{
    /**
     * {@inheritdoc}
     */
    public function match(array $document)
    {
        return true;
    }
}