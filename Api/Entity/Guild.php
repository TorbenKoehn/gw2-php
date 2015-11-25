<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\Guild\EmblemInfo;
use GuildWars2\Api\EntityBase;

class Guild extends EntityBase
{

    private $_id;
    private $_name;
    private $_tag;
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
                    $this,
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