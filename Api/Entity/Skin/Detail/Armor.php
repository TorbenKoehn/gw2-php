<?php

namespace GuildWars2\Api\Entity\Skin\Detail;

use GuildWars2\Api\Entity\Skin\DetailBase;

class Armor extends DetailBase
{

    private $_weightClass;

    public function __construct($type, $weightClass)
    {

        parent::__construct($type);

        $this->_weightClass = $weightClass;
    }

    /**
     * @return mixed
     */
    public function getWeightClass()
    {
        return $this->_weightClass;
    }
}