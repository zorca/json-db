<?php

namespace JsonDb\Operation;

use JsonDb\JsonDbException;

class Insert
{
    protected $toBeInserted;

    public function __construct(array &$data)
    {
        // Check new object
        if (isset($data['_id'])) {
            throw new JsonDbException('Already inserted');
        }

        // Compute _id for the document and adds it
        $_id = substr(md5(time()), 0, 6);
        $data['_id'] = $_id;

        $this->toBeInserted = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(array &$collection)
    {
        array_push($collection, $this->toBeInserted);
    }
}