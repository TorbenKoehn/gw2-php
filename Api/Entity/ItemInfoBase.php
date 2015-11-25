<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class ItemInfoBase extends SetEntityBase
{
    private $_itemId;
    private $_amount;
    private $_skinId;
    private $_upgradeIds;
    private $_infusionIds;
    private $_bindType;
    private $_boundCharacterName;

    protected function init()
    {

        $this->_itemId = null;
        $this->_amount = null;
        $this->_skinId = null;
        $this->_upgradeIds = [];
        $this->_infusionIds = [];
        $this->_bindType = null;
        $this->_boundCharacterName = null;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->_itemId;
    }

    /**
     * @return Item
     */
    public function getItem()
    {

        return $this->getApi()->items->getOne($this->_itemId);
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return mixed
     */
    public function getSkinId()
    {
        return $this->_skinId;
    }

    /**
     * @return mixed
     */
    public function getUpgradeIds()
    {
        return $this->_upgradeIds;
    }

    /**
     * @return mixed
     */
    public function getInfusionIds()
    {
        return $this->_infusionIds;
    }

    /**
     * @return mixed
     */
    public function getBindType()
    {
        return $this->_bindType;
    }

    /**
     * @return mixed
     */
    public function getBoundCharacterName()
    {
        return $this->_boundCharacterName;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_itemId = intval($value);
                break;
            case 'count':

                $this->_amount = $value;
                break;
            case 'skin':

                $this->_skinId = $value;
                break;
            case 'upgrades':

                $this->_upgradeIds = array_map('intval', $value);
                break;
            case 'infusions':

                $this->_infusionIds = array_map('intval', $value);
                break;
            case 'binding':

                $this->_bindType = $value;
                break;
            case 'bound_to':

                $this->_boundCharacterName = $value;
                break;
        }
    }
}