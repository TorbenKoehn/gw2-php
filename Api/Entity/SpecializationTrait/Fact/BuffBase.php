<?php

namespace GuildWars2\Api\Entity\SpecializationTrait\Fact;


abstract class BuffBase extends BuffInfoBase
{

    private $_duration;
    private $_stacks;

    public function __construct(
        $text, $iconUri, $duration, $status, $description, $stacks
    )
    {

        parent::__construct($text, $iconUri, $status, $description);

        $this->_duration = $duration;
        $this->_stacks = $stacks;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->_duration;
    }

    /**
     * @return mixed
     */
    public function getStacks()
    {
        return $this->_stacks;
    }
}