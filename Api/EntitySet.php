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
        $this->_entities = [];
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

    public function load(array $indexes = null, $page = null, $pageSize = null, $continue = false)
    {

        if (!$indexes && $page === null) {

            $continue = true;
        }

        //We don't load indexes that we already have!
        //This only works if we pass explizit indexes
        if ($indexes && count($indexes) > 0 && $indexes[0] !== 'all') {

            $unfinishedIndexes = array_filter($indexes, function ($index) {

                //Normalize index
                $index = is_numeric($index) ? intval($index) : $index;

                return !isset($this->_entities[$index]) || !$this->_entities[$index]->isFinished();
            });

            if (empty($unfinishedIndexes))
                return $this;

            $indexes = $unfinishedIndexes;
        }

        //We can only pass 200 ids at once
        if ($indexes && count($indexes) > 200) {

            $len = count($indexes);
            for ($i = 0; $i < $len; $i += 200) {

                $this->load(array_slice($indexes, $i, 200), $page, $pageSize, $continue);
            }

            return $this;
        }

        $page = $this->fetch($indexes, $page, $pageSize);
        foreach ($page->getData() as $indexValue => $info) {

            if (!is_array($info)) {

                if ($info === null) {

                    //This may indicate a slot, e.g. in inventories
                    //We check it at least to be able to read it later
                    $this->_entities[$indexValue] = null;
                }
                continue;
            }

            $this->update($indexValue, $info, true);
        }

        if ($continue && ($page->getNumber() + 1 < $page->getTotal()))
            return $this->load($indexes, $page->getNumber() + 1, $page->getSize(), true);

        return $this;
    }

    public function loadOne($index)
    {

        $index = is_numeric($index) ? intval($index) : $index;

        //If its already loaded, don't load it
        if (isset($this->_entities[$index]) && $this->_entities[$index]->isFinished())
            return $this;

        $info = $this->fetchOne($index)->getData();
        $this->update($index, $info, true);

        return $this;
    }

    public function getIndexes()
    {

        $this->loadIndexes();

        return array_keys($this->_entities);
    }

    public function get(array $indexes = null, $page = null, $pageSize = null, $continue = false)
    {

        $this->load($indexes, $page, $pageSize, $continue);

        return $indexes ? array_intersect_key($this->_entities, array_flip($indexes)) : $this->_entities;
    }

    public function getOne($index)
    {

        $index = is_numeric($index) ? intval($index) : $index;
        $this->loadOne($index);

        return $this->_entities[$index];
    }

    protected function update($indexValue, array $values = null, $finish = false)
    {

        $className = $this->_className;
        $indexField = $className::getIndexField();

        if (isset($values[$indexField])) {

            $indexValue = $values[$indexField];
            unset($values[$indexValue]);
        }

        //Normalize index
        $indexValue = is_numeric($indexValue) ? intval($indexValue) : $indexValue;

        if (!isset($this->_entities[$indexValue]))
            $this->_entities[$indexValue] = new $className($this, $indexValue);

        if ($values) {

            $this->_entities[$indexValue]->update($values, $finish);
        }

        return $this;
    }

    public function fetchIndexes()
    {

        return $this->_api->fetch($this->_path);
    }

    public function fetch(array $indexes = null, $page = null, $pageSize = null)
    {

        $data = [];

        if (!empty($indexes)) {

            $data['ids'] = implode(',', $indexes);
        } else if ($this->_supportsAll && $page === null) {

            $data['ids'] = 'all';
        } else if ($page === null) {

            $indexes = $this->fetchIndexes()->getData();

            //We will get everything above 20 indexes in a paged manner.
            //For that we just omit id and set page to 0
            if (count($indexes) > 20) {

                $page = 0;
                //It might also be wise to have a larger page size
                //Notice that 200 seems to be the max page size given by arena.net
                $pageSize = 200;
            } else {

                $data['ids'] = implode(',', $indexes);
            }
        }

        if ($page !== null)
            $data['page'] = $page;

        if ($pageSize !== null)
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

    public function __get($index)
    {

        return $this->getOne($index);
    }
}