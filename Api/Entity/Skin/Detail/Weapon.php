<?php

namespace GuildWars2\Api\Entity\Skin\Detail;

use GuildWars2\Api\Entity\Skin\DetailBase;

class Weapon extends DetailBase
{

    private $_damageType;

    public function __construct($type, $damageType)
    {

        parent::__construct($type);

        $this->_damageType = $damageType;
    }

    /**
     * @return mixed
     */
    public function getDamageType()
    {
        return $this->_damageType;
    }
}