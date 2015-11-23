<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;

use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

abstract class BuffInfoBase extends FactBase
{

    private $_status;
    private $_description;

    public function __construct(
        $text, $iconUri, $status, $description
    )
    {

        parent::__construct($text, $iconUri);

        $this->_status = $status;
        $this->_description = $description;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }
}