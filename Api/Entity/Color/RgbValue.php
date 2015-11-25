<?php

namespace GuildWars2\Api\Entity\Color;

use GuildWars2\Api\Entity\Color;

class RgbValue
{

    private $_red;
    private $_green;
    private $_blue;

    public function __construct(
        $red,
        $green,
        $blue
    )
    {

        $this->_red = $red;
        $this->_green = $green;
        $this->_blue = $blue;
    }

    /**
     * @return mixed
     */
    public function getRed()
    {
        return $this->_red;
    }

    /**
     * @return mixed
     */
    public function getGreen()
    {
        return $this->_green;
    }

    /**
     * @return mixed
     */
    public function getBlue()
    {
        return $this->_blue;
    }

    public function __toString()
    {

        return "rgb({$this->_red},{$this->_green},{$this->_blue})";
    }
}