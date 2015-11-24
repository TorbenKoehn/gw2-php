<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class SpecializationTrait extends SkillBase
{


    private $_tier;
    private $_slotType;
    private $_skills;
    private $_specializationId;

    protected function init()
    {
        parent::init();

        $this->_tier = null;
        $this->_slotType = null;
        $this->_skills = [];
        $this->_specializationId = null;
    }

    protected function set($key, $value)
    {
        parent::set($key, $value);

        switch ($key) {
            case 'tier':

                $this->_tier = intval($value);
                break;
            case 'slot':

                $this->_slotType = $value;
                break;
            case 'skills':

                foreach ($value as $skillInfo) {

                    //TODO: This should normally be a "skills" entity set, but it doesn't exist!
                    $skill = new Skill($this->getSet(), $skillInfo['id']);
                    unset($skillInfo['id']);
                    $skill->update($skillInfo, true);
                    $this->_skills[] = $skill;
                }
                break;
            case 'specialization':

                $this->_specializationId = intval($value);
                break;
        }
    }
}