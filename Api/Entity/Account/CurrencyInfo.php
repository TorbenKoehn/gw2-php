<?php

namespace GuildWars2\Api\Entity\Account;

use GuildWars2\Api\Entity\Currency;
use GuildWars2\Api\SetEntityBase;

class CurrencyInfo extends SetEntityBase
{

    private $_currencyId;
    private $_value;

    protected function init()
    {

        $this->_currencyId = null;
        $this->_value = null;
    }

    /**
     * @return mixed
     */
    public function getCurrencyId()
    {
        return $this->_currencyId;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {

        return $this->getApi()->currencies->getOne($this->_currencyId);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_currencyId = $value;
                break;
            case 'value':

                $this->_value = $value;
                break;
        }
    }
}