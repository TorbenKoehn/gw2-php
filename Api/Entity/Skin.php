<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class Skin extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_type;
    private $_flags;
    private $_restrictions;
    private $_iconUri;
    private $_description;
    private $_details;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_type = null;
        $this->_flags = [];
        $this->_restrictions = [];
        $this->_iconUri = null;
        $this->_description = null;
        $this->_details = null;
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
    public function getName()
    {
        return $this->_name;
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

    /**
     * @return mixed
     */
    public function getRestrictions()
    {
        return $this->_restrictions;
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
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->_details;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = intval($value);
                break;
            case 'name':

                $this->_name = $value;
                break;
            case 'type':

                $this->_type = $value;
                break;
            case 'flags':

                $this->_flags = $value;
                break;
            case 'restrictions':

                $this->_restrictions = $value;
                break;
            case 'icon':

                $this->_iconUri = $value;
                break;
            case 'description':

                $this->_description = $value;
                break;
            case 'details':

                switch ($this->_type) {
                    default:
                    case 'Armor':

                        $this->_details = new Skin\Detail\Armor(
                            $value['type'],
                            $value['weight_class']
                        );
                        break;
                    case 'Weapon':

                        $this->_details = new Skin\Detail\Weapon(
                            $value['type'],
                            $value['damage_type']
                        );
                        break;
                }
                break;
        }
    }
}