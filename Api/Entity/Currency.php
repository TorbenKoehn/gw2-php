<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class Currency extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_description;
    private $_iconUri;
    private $_order;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_description = null;
        $this->_iconUri = null;
        $this->_order = null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return mixed
     */
    public function getIconUri()
    {
        return $this->_iconUri;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->_order;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = $value;
                break;
            case 'name':

                $this->_name = $value;
                break;
            case 'description':

                $this->_description = $value;
                break;
            case 'icon':

                $this->_iconUri = $value;
                break;
            case 'order':

                $this->_order = $value;
                break;
        }
    }
}