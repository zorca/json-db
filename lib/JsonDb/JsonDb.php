<?php

namespace JsonDb;

/**
 * Manage Collections.
 *
 * @package JsonDb
 */
class JsonDb
{
    protected $path;
    protected $extension = ".json";
    protected $collections = array();

    /**
     * @param $path Directory where to store collection files.
     */
    public function __construct($path)
    {
        // Check that path suits our needs
        $path = realpath($path);
        if (! is_dir($path)) {
            throw new JsonDbException('Path not found');

        }
        if (! is_writeable($path)) {
            throw new JsonDbException('Path not writeable');
        }

        $this->path = $path;
    }

    /**
     * Get a collection.
     *
     * @param  string         $name Collection name.
     * @return JsonCollection
     */
    public function getCollection($name)
    {
        if (! isset($this->collections[$name])) {
            $filepath = $this->path . DIRECTORY_SEPARATOR . $name . $this->extension;
            $this->collections[$name] = new JsonCollection($filepath);
        }

        return $this->collections[$name];
    }

    /**
     * Proxy for getCollection.
     *
     * @param $name
     * @return JsonCollection
     */
    public function __get($name)
    {
        return $this->getCollection($name);
    }

    /**
     * Sets the json files extension.
     *
     * @param  string $extension
     * @return $this Fluent interface.
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }
}
