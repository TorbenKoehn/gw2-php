<?php

namespace GuildWars2\Api\Entity;

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
            case 'name':

                $this->_name = $value;
                break;
            case 'level':

                $this->_level = intval($value);
                break;
        }
    }

    public static function getIndexField()
    {

        return 'name';
    }
}