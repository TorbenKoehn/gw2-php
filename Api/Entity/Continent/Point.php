<?php

namespace GuildWars2\Api\Entity\Continent;

class Point
{

    private $_x;
    private $_y;

    public function __construct($x = null, $y = null)
    {

        $this->_x = $x ? $x : 0;
        $this->_y = $y ? $y : 0;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->_x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->_y;
    }
}