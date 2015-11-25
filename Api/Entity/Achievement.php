<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class Achievement extends SetEntityBase
{

    private $_id;
    private $_iconUri;
    private $_name;
    private $_description;
    private $_requirement;
    private $_type;
    private $_flags;

    protected function init()
    {

        $this->_id = null;
        $this->_iconUri = null;
        $this->_name = null;
        $this->_description = null;
        $this->_requirement = null;
        $this->_type = null;
        $this->_flags = [];
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
    public function getIconUri()
    {
        return $this->_iconUri;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return mixed
     */
    public function getRequirement()
    {
        return $this->_requirement;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return mixed
     */
    public function getFlags()
    {
        return $this->_flags;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = intval($value);
                break;
            case 'icon':

                $this->_iconUri = $value;
                break;
            case 'name':

                $this->_name = $value;
                break;
            case 'description':

                $this->_description = $value;
                break;
            case 'requirement':

                $this->_requirement = $value;
                break;
            case 'type':

                $this->_type = $value;
                break;
            case 'flags':

                $this->_flags = $value;
                break;
        }
    }
}