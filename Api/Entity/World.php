<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class World extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_population;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_population = null;
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
    public function getPopulation()
    {
        return $this->_population;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = $value;
                break;
            case 'name':

                $this->_name = $value;
                break;
            case 'population':

                $this->_population = $value;
                break;
        }
    }
}