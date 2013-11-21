<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 17/11/13
 * Time: 00:08
 * To change this template use File | Settings | File Templates.
 */

namespace JsonDb;


class JsonCollection
{
    /**
     * @var string Path.
     */
    protected $filepath;

    protected $fileHandle;
    protected $data = array();

    function __construct($filepath)
    {
        $this->filepath = $filepath;

        if (file_exists($filepath)) {
            if(! is_writeable($filepath)){
                throw new JsonDbException('Collection file is not writeable');
            }
            $this->data = json_decode(file_get_contents($this->filepath), true);
        }
        else{
            if(! touch($filepath)){
                throw new JsonDbException('Cannot create new collection');
            }
            $this->data = array();
        }

        $this->lockFile();
    }

    public function __destruct()
    {
        if(! is_null($this->data)){
            $this->flush();
            fclose($this->fileHandle);
        }
    }

    /**
     * Removes all data associated to collection.
     */
    public function drop()
    {
        $this->data = null;
        fclose($this->fileHandle);
        unlink($this->filepath);
    }

    /**
     * @return string Path to the database collection file.
     */
    function getFilePath()
    {
        return $this->filepath;
    }



    protected function lockFile() {
        $handle = fopen($this->filepath, "w");
        if (flock($handle, LOCK_EX)) $this->fileHandle = $handle;
        else throw new \Exception("JsonCollection Error: Can't set file-lock");
    }

    /**
     * Write all pending data to file.
     *
     * @return bool
     * @throws \Exception
     */
    protected function flush()
    {
        if (fwrite($this->fileHandle, json_encode($this->data))) return true;
        else throw new \Exception("JsonCollection Error: Can't write data to: ".$this->filepath);
    }

    public function selectAll() {
        return $this->data;
    }

    public function select($key, $val = 0) {
        $result = array();
        if (is_array($key)) $result = $this->select($key[1], $key[2]);
        else {
            $data = $this->data;
            foreach($data as $_key => $_val) {
                if (isset($data[$_key][$key])) {
                    if ($data[$_key][$key] == $val) {
                        $result[] = $data[$_key];
                    }
                }
            }
        }
        return $result;
    }

    public function updateAll($data = array()) {
        if (isset($data[0]) && substr_compare($data[0],$this->filepath,0)) $data = $data[1];
        return $this->data = array($data);
    }

    public function update($key, $val = 0, $newData = array()) {
        $result = false;
        if (is_array($key)) $result = $this->update($key[1], $key[2], $key[3]);
        else {
            $data = $this->data;
            foreach($data as $_key => $_val) {
                if (isset($data[$_key][$key])) {
                    if ($data[$_key][$key] == $val) {
                        $data[$_key] = $newData;
                        $result = true;
                        break;
                    }
                }
            }
            if ($result) $this->data = $data;
        }
        return $result;
    }

    public function insert($data = array()) {
        if (isset($data[0]) && substr_compare($data[0],$this->filepath,0)) $data = $data[1];
        $this->data[] = $data;
        return true;
    }

    public function deleteAll() {
        $this->data = array();
        return true;
    }

    public function delete($key, $val = 0) {
        $result = 0;
        if (is_array($key)) $result = $this->delete($key[1], $key[2]);
        else {
            $data = $this->data;
            foreach($data as $_key => $_val) {
                if (isset($data[$_key][$key])) {
                    if ($data[$_key][$key] == $val) {
                        unset($data[$_key]);
                        $result++;
                    }
                }
            }
            if ($result) {
                sort($data);
                $this->data = $data;
            }
        }
        return $result;
    }
}