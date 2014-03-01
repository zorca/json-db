<?php

namespace JsonDb\Operation;

/**
 * An operation against the database, to be performed at flush time.
 *
 * @package JsonDb\Operation
 */
interface OperationInterface {
    public function execute(array &$collection);
}