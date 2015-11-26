<?php

namespace GuildWars2\Api\Entity\Continent;

use GuildWars2\Api\Entity\Continent\Floor\Region;
use GuildWars2\Api\SetEntityBase;

class Floor extends SetEntityBase
{

    private $_id;
    private $_textureSize;
    private $_regions;

    protected function init()
    {

        $this->_id = null;
        $this->_textureSize = null;

        $this->_regions = $this->createChildSet(
            'regions',
            '/regions',
            Region::class
        );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getTextureSize()
    {
        return $this->_textureSize;
    }

    /**
     * @return mixed
     */
    public function getRegions()
    {
        return $this->_regions;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = intval($value);
                break;
            case 'texture_dims':

                $this->_textureSize = new Size(
                    $value[0],
                    $value[1]
                );
                break;
            case 'regions':

                //well....not very consistent, arena.net...
                //This costs traffic.
                break;
        }
    }
}