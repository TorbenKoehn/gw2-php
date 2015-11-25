<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class Item extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_iconUri;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_iconUri = null;
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

    /**
     * @return mixed
     */
    public function getIconUri()
    {
        return $this->_iconUri;
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
            case 'icon':

                $this->_iconUri = $value;
                break;
        }
    }
}