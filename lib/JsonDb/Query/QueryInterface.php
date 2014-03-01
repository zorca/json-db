<?php

namespace JsonDb\Query;

interface QueryInterface {
    /**
     * @param array $document
     * @return bool True if given document matches this selector.
     */
    public function match(array $document);
}