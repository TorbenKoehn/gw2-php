<?php

namespace GuildWars2\Api;

use GuildWars2\Api;

abstract class EntityBase
{

    private $_api;
    private $_path;
    private $_finished;

    public function __construct(Api $api, $path, $init = true)
    {

        $this->_api = $api;
        $this->_path = $path;

        if ($init)
            $this->init();
    }

    /**
     * @return Api
     */
    public function getApi()
    {

        return $this->_api;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }


    public function update(array $values = null, $finish = false)
    {

        foreach ($values as $key => $value) {

            $this->set($key, $value);
        }

        if ($finish)
            $this->_finished = true;

        return $this;
    }

    public function isFinished()
    {

        return $this->_finished;
    }

    public function getChildSet($name, $path, $className, $indexField = null)
    {

        return new EntitySet(
            $this->_api,
            $name,
            $this->_path.$path,
            $className,
            $indexField
        );
    }

    abstract protected function init();
    abstract protected function set($key, $value);
}