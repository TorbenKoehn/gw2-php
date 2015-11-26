<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\Guild\EmblemInfo;
use GuildWars2\Api\EntityBase;

/**
 * Class Guild
 *
 * Notice that guilds fall back to /v1 currently!
 * This happens in Api->getGuild.
 *
 * Upon seeing v2, it will be a real EntitySet (Which is just
 * replacing EntityBase with SetEntityBase and adding a new set
 * to the Api constructor)
 *
 * @package GuildWars2\Api\Entity
 */
class Guild extends EntityBase
{

    private $_id;
    private $_name;
    private $_tag;

    /**
     * @var EmblemInfo
     */
    private $_emblemInfo;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_tag = null;
        $this->_emblemInfo = null;
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
    public function getTag()
    {
        return $this->_tag;
    }

    /**
     * @return mixed
     */
    public function getEmblemInfo()
    {
        return $this->_emblemInfo;
    }

    public function getEmblemImage(array $backgroundColor = null)
    {

        return $this->_emblemInfo->getImage();
    }

    public function getEmblemDataUri()
    {

        return $this->_emblemInfo->getDataUri();
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'guild_id':

                $this->_id = $value;
                break;
            case 'guild_name':

                $this->_name = $value;
                break;
            case 'tag':

                $this->_tag = $value;
                break;
            case 'emblem':

                $this->_emblemInfo = new EmblemInfo(
                    $this->getApi(),
                    $value['background_id'],
                    $value['foreground_id'],
                    $value['flags'],
                    $value['background_color_id'],
                    $value['foreground_primary_color_id'],
                    $value['foreground_secondary_color_id']
                );
                break;

        }
    }
}