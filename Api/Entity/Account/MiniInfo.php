<?php

namespace GuildWars2\Api\Entity\Account;

use GuildWars2\Api\SetEntityBase;
use GuildWars2\Api\Entity\Mini;

class MiniInfo extends SetEntityBase
{
    private $_miniId;

    protected function init()
    {

        $this->_miniId = null;
    }

    /**
     * @return mixed
     */
    public function getMiniId()
    {
        return $this->_miniId;
    }

    /**
     * @return Mini
     */
    public function getMini()
    {

        return $this->getApi()->minis->getOne($this->_miniId);
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_miniId = $value;
                break;
        }
    }
}