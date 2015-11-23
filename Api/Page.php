<?php

namespace GuildWars2\Api;

class Page implements \IteratorAggregate
{

    private $_path;
    private $_number;
    private $_total;
    private $_size;
    private $_count;
    private $_totalCount;
    private $_data;

    public function __construct(
        $path,
        $number,
        $total,
        $size,
        $count,
        $totalCount,
        array $data
    )
    {

        $this->_path = $path;
        $this->_number = $number;
        $this->_total = $total;
        $this->_size = $size;
        $this->_count = $count;
        $this->_totalCount = $totalCount;
        $this->_data = $data;

    }

    public function getIterator()
    {

        foreach ($this->_data as $key => $value)
            yield $key => $value;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->_total;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->_count;
    }

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->_totalCount;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    public function __isset($key)
    {

        return isset($this->_data[$key]);
    }

    public function __get($key)
    {

        return $this->__isset($key) ? $this->_data[$key] : null;
    }
}