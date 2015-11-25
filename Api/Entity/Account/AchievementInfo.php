<?php

namespace GuildWars2\Api\Entity\Account;

use GuildWars2\Api\Entity\Achievement;
use GuildWars2\Api\SetEntityBase;

class AchievementInfo extends SetEntityBase
{
    private $_achievementId;
    private $_current;
    private $_max;
    private $_done;
    private $_bits;

    protected function init()
    {

        $this->_achievementId = null;
        $this->_current = null;
        $this->_max = null;
        $this->_done = null;
        $this->_bits = [];
    }

    /**
     * @return mixed
     */
    public function getAchievementId()
    {
        return $this->_achievementId;
    }

    /**
     * @return Achievement
     */
    public function getAchievement()
    {

        return $this->getApi()->achievements->getOne($this->_achievementId);
    }

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->_current;
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return $this->_max;
    }

    /**
     * @return mixed
     */
    public function isDone()
    {
        return $this->_done;
    }

    /**
     * @return mixed
     */
    public function getBits()
    {
        return $this->_bits;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_achievementId = $value;
                break;
            case 'current':

                $this->_current = $value;
                break;
            case 'max':

                $this->_max = $value;
                break;
            case 'done':

                $this->_done = $value;
                break;
            case 'bits':

                $this->_bits = $value;
                break;
        }
    }
}