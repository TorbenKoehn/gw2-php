<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class File extends SetEntityBase
{

    private $_id;
    private $_uri;

    protected function init()
    {

        $this->_id = null;
        $this->_uri;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->_uri;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = $value;
                break;
            case 'icon':

                $this->_uri = $value;
                break;
        }
    }
}