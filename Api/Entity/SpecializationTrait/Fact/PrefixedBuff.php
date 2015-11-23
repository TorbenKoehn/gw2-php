<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\Fact\PrefixedBuff\Prefix;
use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

class PrefixedBuff extends BuffBase
{

    private $_prefix;

    public function __construct(
        $text, $iconUri, $duration, $status, $description, $stacks, Prefix $prefix
    )
    {

        parent::__construct($text, $iconUri, $duration, $status, $description, $stacks);

        $this->_prefix = $prefix;
    }

    /**
     * @return Prefix
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }
}