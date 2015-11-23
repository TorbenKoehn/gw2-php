<?php

namespace GuildWars2\Api;

abstract class SetEntityBase extends EntityBase
{

    private $_set;

    public function __construct(EntitySet $set, $indexValue)
    {
        parent::__construct($set->getApi(), $set->getPath().'/'.urlencode($indexValue), false);

        $this->_set = $set;

        $this->init();
        $this->set(static::getIndexField(), $indexValue);
    }

    /**
     * @return EntitySet
     */
    public function getSet()
    {
        return $this->_set;
    }

    public function getApi()
    {

        return $this->_set->getApi();
    }

    public static function getIndexField()
    {

        return 'id';
    }
}