<?php

namespace GuildWars2\Api\Entity\Account;

use GuildWars2\Api\Entity\Skin;
use GuildWars2\Api\SetEntityBase;

class SkinInfo extends SetEntityBase
{
    private $_skinId;

    protected function init()
    {

        $this->_skinId = null;
    }

    /**
     * @return mixed
     */
    public function getSkinId()
    {
        return $this->_skinId;
    }

    /**
     * @return Skin
     */
    public function getSkin()
    {

        return $this->getApi()->skins->getOne($this->_skinId);
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_skinId = $value;
                break;
        }
    }
}