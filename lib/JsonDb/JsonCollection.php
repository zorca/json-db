<?php

namespace JsonDb;
use JsonDb\Operation\Delete;
use JsonDb\Operation\Insert;
use JsonDb\Operation\Update;
use JsonDb\Query\Query;
use JsonDb\Query\QueryInterface;

/**
 * Handle data inside collection file.
 *
 * Records all operations to be flushed, apply them straight on a recent set of data.
 * On flush, reload data from filesystem, and apply operations on them.
 *
 * @package JsonDb
 */
class JsonCollection
{
    /**
     * @var string Path.
     */
    protected $path;

    /**
     * @var array Where the magic happens.
     */
    protected $data = array();

    /**
     * @var array Store differences.
     */
    protected $operations = array();

    /**
     * @var bool True if has been dropped
     */
    protected $isDropped = false;

    /**
     * @param string $path Path to JSON file holding the collection.
     */
    public function __construct($path)
    {
        $this->path = $path;

        // Create collection file and retrieve data.
        if (file_exists($path)) {
            if (! is_writeable($path)) {
                throw new JsonDbException('Collection file is not writeable');
            }
            $this->refresh();
        } else {
            if (! touch($path)) {
                throw new JsonDbException('Cannot create new collection');
            }
            $this->data = array();
        }
    }

    public function __destruct()
    {
        if (! is_null($this->operations) && ! $this->isDropped) {
            $this->flush();
        }
    }

    /**
     * Removes all data associated to collection.
     */
    public function drop()
    {
        $this->isDropped = true;

        $this->data = null;
        unlink($this->path);
    }

    /**
     * @return string Path to the database collection file.
     */
    public function getFilePath()
    {
        return $this->path;
    }

    /**
     * Refresh data from filesystem
     */
    public function refresh()
    {
        $data = json_decode(file_get_contents($this->path), true);
        if(empty($data)){
            $data = array();
        }
        $this->data = $data;
    }

    /**
     * Perform all pending operations to filesystem.
     *
     * @return bool
     * @throws \Exception
     */
    public function flush()
    {
        $this->refresh();

        foreach($this->operations as $operation){
            $operation->execute($this->data);
        }

        $handle = fopen($this->path, "w");
        try{
            if (! flock($handle, LOCK_EX))
                throw new \Exception("JsonCollection Error: Can't set file-lock");

            if (! fwrite($handle, json_encode($this->data)))
                throw new \Exception("JsonCollection Error: Can't write data to: ".$this->path);
        }
        catch(\Exception $e){
            fclose($handle);
            throw $e;
        }
    }

    /**
     * Find a document inside the collection.
     *
     * @param QueryInterface $query
     * @return array
     */
    public function find(QueryInterface $query = null)
    {
        if (is_null($query)) {
            return $this->data;
        }

        $results = array();
        foreach ($this->data as $d) {
            if ($query->match($d)) {
                array_push($results, $d);
            }
        }
        return $results;
    }

    public function insert(array &$data)
    {
        $this->addOperation(new Insert($data));
    }

    public function update(QueryInterface $query = null, $data)
    {
        $this->addOperation(new Update($query, $data));
    }

    public function delete(QueryInterface $query = null)
    {
        $this->addOperation(new Delete($query));
    }

    // perform operation on local data and store operation
    private function addOperation($operation)
    {
        $operation->execute($this->data);
        array_push($this->operations, $operation);
    }
}
