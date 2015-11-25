<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class Mini extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_unlockDescription;
    private $_iconUri;
    private $_order;
    private $_itemId;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_unlockDescription = null;
        $this->_iconUri = null;
        $this->_order = null;
        $this->_itemId = null;
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
    public function getUnlockDescription()
    {
        return $this->_unlockDescription;
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

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->_itemId;
    }

    public function getItem()
    {

        return $this->getApi()->items->getOne($this->_itemId);
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
            case 'unlock':

                $this->_unlockDescription = $value;
                break;
            case 'icon':

                $this->_iconUri = $value;
                break;
            case 'order':

                $this->_order = $value;
                break;
            case 'item_id':

                $this->_itemId = $value;
                break;
        }
    }
}