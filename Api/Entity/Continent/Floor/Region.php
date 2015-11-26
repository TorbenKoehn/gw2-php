<?php

namespace GuildWars2\Api\Entity\Continent\Floor;

use GuildWars2\Api\Entity\Continent\Point;
use GuildWars2\Api\SetEntityBase;

class Region extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_labelPosition;
    private $_maps;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_labelPosition = null;

        /*$this->_floors = $this->createChildSet(
            'floors',
            '/floors',
            AchievementInfo::class
        );*/
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
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getLabelPosition()
    {
        return $this->_labelPosition;
    }

    /**
     * @return mixed
     */
    public function getMaps()
    {
        return $this->_maps;
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
            case 'label_coord':

                $this->_labelPosition = new Point(
                    $value[0],
                    $value[1]
                );
                break;
        }
    }
}