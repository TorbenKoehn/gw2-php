<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\EntityBase;

class Account extends EntityBase
{

    private $_name;
    private $_worldId;
    private $_guildIds;
    private $_creationDate;
    private $_accessType;
    private $_fractalLevel;

    protected function init()
    {

        $this->_name = null;
        $this->_worldId = null;
        $this->_guildIds = [];
        $this->_creationDate = null;
        $this->_accessType = null;
        $this->_fractalLevel = null;
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