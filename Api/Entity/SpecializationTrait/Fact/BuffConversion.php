<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

class BuffConversion extends FactBase
{

    private $_percent;
    private $_source;
    private $_target;

    public function __construct(
        $text, $iconUri, $percent, $source, $target
    )
    {

        parent::__construct($text, $iconUri);

        $this->_percent = $percent;
        $this->_source = $source;
        $this->_target = $target;
    }

    /**
     * @return mixed
     */
    public function getPercent()
    {
        return $this->_percent;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->_source;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->_target;
    }
}