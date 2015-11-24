<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\Character\CraftingInfo;
use GuildWars2\Api\Entity\Character\SpecializationInfo;
use GuildWars2\Api\SetEntityBase;

class Character extends SetEntityBase
{

    private $_name;
    private $_race;
    private $_gender;
    private $_profession;
    private $_level;
    private $_guildId;
    private $_age;
    private $_creationDate;
    private $_deathCount;
    private $_craftingInfos;
    private $_specalizationInfos;
    private $_equipmentInfos;
    private $_bagInfos;

    protected function init()
    {

        $this->_name = null;
        $this->_race = null;
        $this->_gender = null;
        $this->_profession = null;
        $this->_level = null;
        $this->_guildId = null;
        $this->_age = null;
        $this->_creationDate = null;
        $this->_deathCount = null;
        $this->_craftingInfos = [];
        $this->_specalizationInfos = [];
        $this->_equipmentInfos = [];
        $this->_bagInfos = [];
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
    public function getRace()
    {
        return $this->_race;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @return mixed
     */
    public function getProfession()
    {
        return $this->_profession;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->_level;
    }

    /**
     * @return mixed
     */
    public function getGuildId()
    {
        return $this->_guildId;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->_creationDate;
    }

    /**
     * @return mixed
     */
    public function getDeathCount()
    {
        return $this->_deathCount;
    }

    /**
     * @return CraftingInfo[]
     */
    public function getCraftingInfos()
    {
        return $this->_craftingInfos;
    }

    /**
     * @return array[]
     */
    public function getSpecalizationInfos()
    {
        return $this->_specalizationInfos;
    }

    /**
     * @return SpecializationInfo[]
     */
    public function getPvpSpecializationInfos()
    {

        return $this->_specalizationInfos['pvp'];
    }

    /**
     * @return SpecializationInfo[]
     */
    public function getWvwSpecializationInfos()
    {

        return $this->_specalizationInfos['wvw'];
    }

    /**
     * @return SpecializationInfo[]
     */
    public function getPveSpecializationInfos()
    {

        return $this->_specalizationInfos['pve'];
    }

    /**
     * @return mixed
     */
    public function getEquipmentInfos()
    {
        return $this->_equipmentInfos;
    }

    /**
     * @return mixed
     */
    public function getBagInfos()
    {
        return $this->_bagInfos;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'name':

                $this->_name = $value;
                break;
            case 'race':

                $this->_race = $value;
                break;
            case 'gender':

                $this->_gender = $value;
                break;
            case 'profession':

                $this->_profession = $value;
                break;
            case 'level':

                $this->_level = intval($value);
                break;
            case 'guild':

                $this->_guildId = intval($value);
                break;
            case 'age':

                $this->_age = new \DateTimeImmutable("@$value");
                break;
            case 'created':

                $this->_creationDate = new \DateTimeImmutable($value);
                break;
            case 'deaths':

                $this->_deathCount = intval($value);
                break;
            case 'crafting':

                foreach ($value as $info) {

                    $this->_craftingInfos[$info['discipline']] = new CraftingInfo(
                        $this,
                        $info['discipline'],
                        $info['rating'],
                        $info['active']
                    );
                }
                break;
            case 'specializations':

                foreach ($value as $type => $specInfos) {

                    $this->_specalizationInfos[$type] = [];

                    foreach ($specInfos as $info) {

                        if (!$info)
                            continue;

                        $this->_specalizationInfos[$type][] = new SpecializationInfo(
                            $this,
                            $info['id'],
                            array_filter($info['traits'], 'is_int')
                        );
                    }
                }
                break;
        }
    }

    public static function getIndexField()
    {

        return 'name';
    }
}