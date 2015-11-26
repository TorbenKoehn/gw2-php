<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\Continent\Floor;
use GuildWars2\Api\Entity\Continent\Size;
use GuildWars2\Api\SetEntityBase;

class Continent extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_size;
    private $_minZoom;
    private $_maxZoom;
    private $_floorIds;
    private $_floors;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;

        $this->_floors = $this->createChildSet(
            'floors',
            '/floors',
            Floor::class
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
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return Size
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * @return int
     */
    public function getMinZoom()
    {
        return $this->_minZoom;
    }

    /**
     * @return int
     */
    public function getMaxZoom()
    {
        return $this->_maxZoom;
    }

    /**
     * @return int[]
     */
    public function getFloorIds()
    {
        return $this->_floorIds;
    }

    public function getFloors()
    {

        return $this->_floors;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = intval($value);
                break;
            case 'name':

                $this->_name = $value;
                break;
            case 'continent_dims':

                $this->_size = new Size(
                    $value[0],
                    $value[1]
                );
                break;
            case 'min_zoom':

                $this->_minZoom = $value;
                break;
            case 'max_zoom':

                $this->_maxZoom = $value;
                break;
            case 'floors':

                $this->_floorIds = $value;
                break;
        }
    }
}