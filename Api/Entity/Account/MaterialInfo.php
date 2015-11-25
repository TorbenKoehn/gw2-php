<?php

namespace GuildWars2\Api\Entity\Account;

use GuildWars2\Api\Entity\Item;
use GuildWars2\Api\SetEntityBase;
use GuildWars2\Api\Entity\Color;

class MaterialInfo extends SetEntityBase
{
    private $_itemId;
    private $_amount;
    private $_categoryId;

    protected function init()
    {

        $this->_itemId = null;
        $this->_amount = null;
        $this->_categoryId = null;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->_itemId;
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
    public function getCategoryId()
    {
        return $this->_categoryId;
    }

    /**
     * @return Item
     */
    public function getItem()
    {

        return $this->getApi()->items->getOne($this->_itemId);
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_itemId = $value;
                break;
            case 'count':

                $this->_amount = $value;
                break;
            case 'category':

                $this->_categoryId = $value;
                break;
        }
    }
}