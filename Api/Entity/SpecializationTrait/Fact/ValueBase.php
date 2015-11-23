<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

class ValueBase extends FactBase
{

    private $_value;

    public function __construct(
        $text, $iconUri, $value
    )
    {

        parent::__construct($text, $iconUri);

        $this->_value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }
}