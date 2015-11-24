<?php

namespace GuildWars2\Api\Entity\Character;

use GuildWars2\Api\Entity\Character;
use GuildWars2\Api\Entity\Specialization;
use GuildWars2\Api\Entity\SpecializationTrait;

class SpecializationInfo
{

    private $_character;
    private $_specializationId;
    private $_traitIds;

    public function __construct(Character $character, $specializationId, array $traitIds)
    {

        $this->_character = $character;
        $this->_specializationId = $specializationId;
        $this->_traitIds = $traitIds;
    }

    /**
     * @return Character
     */
    public function getCharacter()
    {
        return $this->_character;
    }

    /**
     * @return mixed
     */
    public function getSpecializationId()
    {
        return $this->_specializationId;
    }

    /**
     * @return Specialization
     */
    public function getSpecialization()
    {

        return $this->_character->getApi()->specializations->getOne($this->_specializationId);
    }

    /**
     * @return array
     */
    public function getTraitIds()
    {
        return $this->_traitIds;
    }

    /**
     * @return SpecializationTrait[]
     */
    public function getTraits()
    {

        return $this->_character->getApi()->traits->get($this->_traitIds);
    }
}