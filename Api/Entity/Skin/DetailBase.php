<?php

namespace GuildWars2\Api\Entity\Skin;

use GuildWars2\Api\Entity\Skin;

abstract class DetailBase
{

    private $_type;

    public function __construct($type)
    {

        $this->_type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }
}