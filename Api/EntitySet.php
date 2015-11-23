<?php

namespace GuildWars2\Api;

use GuildWars2\Api;

class EntitySet implements \IteratorAggregate
{

    private $_api;
    private $_name;
    private $_path;
    private $_className;
    private $_supportsAll;

    /**
     * @var SetEntityBase[]
     */
    private $_entities;

    public function __construct(Api $api, $name, $path, $className, $supportsAll = true)
    {

        if (!is_subclass_of($className, SetEntityBase::class))
            throw new Exception(
                "Failed to create entity set: Entity class is not a valid SetEntityBase subclass"
            );

        $this->_api = $api;
        $this->_name = $name;
        $this->_path = $path;
        $this->_className = $className;
        $this->_supportsAll = $supportsAll;
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
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->_className;
    }

    /**
     * @return EntityBase[]
     */
    public function getEntities()
    {
        return $this->_entities;
    }

    public function loadIndexes()
    {

        $indexes = $this->fetchIndexes();

        foreach ($indexes as $indexValue)
            $this->update($indexValue);

        return $this;
    }

    public function load(array $indexes = null, $page = null, $pageSize = null)
    {

        foreach ($this->fetch($indexes, $page, $pageSize) as $indexValue => $info) {

            $className = $this->_className;
            $indexField = $className::getIndexField();

            if (isset($info[$indexField])) {

                $indexValue = $info[$indexField];
                unset($info[$indexValue]);
            }

            $this->update($indexValue, $info);
        }

        return $this;
    }

    public function loadOne($index)
    {

        $info = $this->fetchOne($index)->getData();

        $className = $this->_className;
        $indexField = $className::getIndexField();

        if (isset($info[$indexField])) {

            $index = $info[$indexField];
            unset($info[$index]);
        }

        $this->update($index, $info);

        return $this;
    }

    public function getIds()
    {

        $this->loadIndexes();

        return array_keys($this->_entities);
    }

    public function get(array $indexes = null)
    {

        $this->load($indexes);

        return $indexes ? array_intersect_key($this->_entities, array_flip($indexes)) : $this->_entities;
    }

    public function getOne($index)
    {

        $index = is_numeric($index) ? intval($index) : $index;
        $this->loadOne($index);

        return $this->_entities[$index];
    }

    protected function update($indexValue, array $values = null)
    {

        //Normalize index
        $indexValue = is_numeric($indexValue) ? intval($indexValue) : $indexValue;

        $className = $this->_className;
        if (!isset($this->_entities[$indexValue]))
            $this->_entities[$indexValue] = new $className($this, $indexValue);

        if ($values) {

            $this->_entities[$indexValue]->update($values);
        }

        return $this;
    }

    public function fetchIndexes()
    {

        return $this->_api->fetch($this->_path);
    }

    public function fetch(array $indexes = null, $page = null, $pageSize = null)
    {

        $data = ['ids' => implode(
            ',',
            $indexes ? $indexes : (
                $this->_supportsAll
              ? ['all']
              : $this->fetchIndexes()->getData()
            )
        )];

        if ($page)
            $data['page'] = $page;

        if ($pageSize)
            $data['page_size'] = $pageSize;

        return $this->_api->fetch($this->_path, $data);
    }

    public function fetchOne($index)
    {

        return $this->_api->fetch($this->_path.'/'.urlencode($index));
    }

    public function getIterator()
    {

        foreach ($this->get() as $id => $entity)
            yield $id => $entity;
    }
}