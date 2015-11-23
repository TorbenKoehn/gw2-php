<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

class ComboField extends FactBase
{

    private $_type;

    public function __construct(
        $text, $iconUri, $type
    )
    {

        parent::__construct($text, $iconUri);

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