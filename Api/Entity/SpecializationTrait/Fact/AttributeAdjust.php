<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

class AttributeAdjust extends ValueBase
{

    private $_attribute;

    public function __construct(
        $text, $iconUri, $value, $attribute
    )
    {

        parent::__construct($text, $iconUri, $value);

        $this->_attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->_attribute;
    }
}