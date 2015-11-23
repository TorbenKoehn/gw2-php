<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

class ComboFinisher extends FactBase
{

    private $_type;
    private $_percent;

    public function __construct(
        $text, $iconUri, $type, $percent
    )
    {

        parent::__construct($text, $iconUri);

        $this->_type = $type;
        $this->_percent = $percent;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return mixed
     */
    public function getPercent()
    {
        return $this->_percent;
    }
}