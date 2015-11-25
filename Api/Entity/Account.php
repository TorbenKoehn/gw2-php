<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\Account\AchievementInfo;
use GuildWars2\Api\Entity\Account\BankItemInfo;
use GuildWars2\Api\Entity\Account\DyeInfo;
use GuildWars2\Api\Entity\Account\MaterialInfo;
use GuildWars2\Api\EntityBase;
use GuildWars2\Api\EntitySet;

class Account extends EntityBase
{

    private $_name;
    private $_worldId;
    private $_guildIds;
    private $_creationDate;
    private $_accessType;
    private $_fractalLevel;

    private $_achievementInfos;
    private $_bankItemInfos;
    private $_dyeInfos;
    private $_materialInfos;

    protected function init()
    {

        $this->_name = null;
        $this->_worldId = null;
        $this->_guildIds = [];
        $this->_creationDate = null;
        $this->_accessType = null;
        $this->_fractalLevel = null;

        $this->_achievementInfos = $this->createChildSet(
            'accountAchievements',
            '/achievements',
            AchievementInfo::class
        );

        $this->_bankItemInfos = $this->createChildSet(
            'accountBankItems',
            '/bank',
            BankItemInfo::class
        );

        $this->_dyeInfos = $this->createChildSet(
            'accountDyes',
            '/dyes',
            DyeInfo::class
        );

        $this->_materialInfos = $this->createChildSet(
            'accountMaterials',
            '/materials',
            MaterialInfo::class
        );
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
    public function getWorldId()
    {
        return $this->_worldId;
    }

    /**
     * @return mixed
     */
    public function getGuildIds()
    {
        return $this->_guildIds;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreationDate()
    {
        return $this->_creationDate;
    }

    /**
     * @return mixed
     */
    public function getAccessType()
    {
        return $this->_accessType;
    }

    /**
     * @return mixed
     */
    public function getFractalLevel()
    {
        return $this->_fractalLevel;
    }

    /**
     * @return EntitySet
     */
    public function getAchievementInfos($loadAchievements = false)
    {

        //Allows to pre-load achievements in one fetch
        if ($loadAchievements) {

            $ids = array_values(array_map(function($info) {

                if (!$info)
                    return;

                return $info->getAchievementId();
            }, iterator_to_array($this->_achievementInfos)));

            $this->getApi()->achievements->load($ids);
        }

        return $this->_achievementInfos;
    }

    /**
     * @return EntitySet
     */
    public function getBankItemInfos($loadItems = false)
    {

        //Allows to pre-load items in one fetch
        if ($loadItems) {

            $ids = array_values(array_map(function($info) {

                if (!$info)
                    return;

                return $info->getItemId();
            }, iterator_to_array($this->_bankItemInfos)));

            $this->getApi()->items->load($ids);
        }

        return $this->_bankItemInfos;
    }

    /**
     * @return EntitySet
     */
    public function getDyeInfos($loadColors = false)
    {

        if (count($this->_dyeInfos->getEntities()) < 1)
            $this->_dyeInfos->loadIndexes();

        //Allows to pre-load items in one fetch
        if ($loadColors) {

            $ids = array_values(array_map(function($info) {

                if (!$info)
                    return;

                return $info->getColorId();
            }, iterator_to_array($this->_dyeInfos)));

            $this->getApi()->colors->load($ids);
        }

        return $this->_dyeInfos;
    }

    /**
     * @return EntitySet
     */
    public function getMaterialInfos($loadItems = false)
    {

        //Allows to pre-load items in one fetch
        if ($loadItems) {

            $ids = array_values(array_map(function($info) {

                if (!$info)
                    return;

                return $info->getItemId();
            }, iterator_to_array($this->_materialInfos)));

            $this->getApi()->items->load($ids);
        }

        return $this->_materialInfos;
    }


    protected function set($key, $value)
    {

        switch ($key) {
            case 'name':

                $this->_name = $value;
                break;
            case 'world':

                $this->_worldId = intval($value);
                break;
            case 'guilds':

                $this->_guildIds = $value;
                break;
            case 'created':

                $this->_creationDate = new \DateTimeImmutable($value);
                break;
            case 'access':

                $this->_accessType = $value;
                break;
            case 'fractal_level':

                $this->_fractalLevel = intval($value);
                break;
        }
    }
}