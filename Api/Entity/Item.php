<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class Item extends SetEntityBase
{

    private $_id;
    private $_name;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = intval($value);
                break;
            case 'name':

                $this->_name = $value;
                break;
        }
    }
}