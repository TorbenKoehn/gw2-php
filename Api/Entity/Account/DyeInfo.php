<?php

namespace GuildWars2\Api\Entity\Account;

use GuildWars2\Api\SetEntityBase;
use GuildWars2\Api\Entity\Color;

class DyeInfo extends SetEntityBase
{
    private $_colorId;

    protected function init()
    {

        $this->_colorId = null;
    }

    /**
     * @return mixed
     */
    public function getColorId()
    {
        return $this->_colorId;
    }

    /**
     * @return Color
     */
    public function getColor()
    {

        return $this->getApi()->colors->getOne($this->_colorId);
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_colorId = $value;
                break;
        }
    }
}