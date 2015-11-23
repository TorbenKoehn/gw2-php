<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

class Damage extends FactBase
{

    private $_hitCount;

    public function __construct(
        $text, $iconUri, $hitCount
    )
    {

        parent::__construct($text, $iconUri);

        $this->_hitCount = $hitCount;
    }

    /**
     * @return mixed
     */
    public function getHitCount()
    {
        return $this->_hitCount;
    }
}