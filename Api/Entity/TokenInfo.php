<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\Account\AchievementInfo;
use GuildWars2\Api\Entity\Account\BankItemInfo;
use GuildWars2\Api\Entity\Account\CurrencyInfo;
use GuildWars2\Api\Entity\Account\DyeInfo;
use GuildWars2\Api\Entity\Account\MaterialInfo;
use GuildWars2\Api\Entity\Account\MiniInfo;
use GuildWars2\Api\Entity\Account\SkinInfo;
use GuildWars2\Api\EntityBase;
use GuildWars2\Api\EntitySet;

class TokenInfo extends EntityBase
{

    private $_key;
    private $_name;
    private $_permissions;

    protected function init()
    {

        $this->_key = null;
        $this->_name = null;
        $this->_permissions = [];
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->_key;
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
    public function getPermissions()
    {
        return $this->_permissions;
    }

    public function hasPermission($permission)
    {

        return in_array(strtolower($permission), $this->_permissions);
    }

    public function hasAccountPermission()
    {

        return $this->hasPermission('account');
    }

    public function hasCharacterPermission()
    {

        return $this->hasPermission('character');
    }

    public function hasInventoryPermission()
    {

        return $this->hasPermission('character');
    }

    public function hasTradingPostPermission()
    {

        return $this->hasPermission('tradingpost');
    }

    public function hasWalletPermission()
    {

        return $this->hasPermission('wallet');
    }

    public function hasUnlocksPermission()
    {

        return $this->hasPermission('unlocks');
    }

    public function hasPvpPermission()
    {

        return $this->hasPermission('pvp');
    }

    public function hasBuildsPermission()
    {

        return $this->hasPermission('builds');
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_key = $value;
                break;
            case 'name':

                $this->_name = $value;
                break;
            case 'permissions':

                $this->_permissions = $value;
                break;
        }
    }
}