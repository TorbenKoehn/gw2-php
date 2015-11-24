<?php

namespace GuildWars2\Api\Entity\Character;

use GuildWars2\Api\Entity\Character;

class CraftingInfo
{

    private $_character;
    private $_discipline;
    private $_level;
    private $_active;

    public function __construct(Character $character, $discipline, $level, $active)
    {

        $this->_character = $character;
        $this->_discipline = $discipline;
        $this->_level = $level;
        $this->_active = $active;
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
    public function getDiscipline()
    {
        return $this->_discipline;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->_level;
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->_active;
    }
}