<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

class Specialization extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_profession;
    private $_elite;
    private $_minorTraitIds;
    private $_majorTraitIds;
    private $_iconUri;
    private $_backgroundUri;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_profession = null;
        $this->_elite = null;
        $this->_minorTraitIds = [];
        $this->_majorTraitIds = [];
        $this->_iconUri = null;
        $this->_backgroundUri = null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
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
    public function getProfession()
    {
        return $this->_profession;
    }

    /**
     * @return mixed
     */
    public function isElite()
    {
        return $this->_elite;
    }

    /**
     * @return mixed
     */
    public function getMinorTraitIds()
    {
        return $this->_minorTraitIds;
    }

    public function getMinorTraits()
    {

        return $this->getApi()->traits->get($this->_minorTraitIds);
    }

    /**
     * @return mixed
     */
    public function getMajorTraitIds()
    {
        return $this->_majorTraitIds;
    }

    public function getMajorTraits()
    {

        return $this->getApi()->traits->get($this->_majorTraitIds);
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
    public function getBackgroundUri()
    {
        return $this->_backgroundUri;
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
            case 'profession':

                $this->_profession = $value;
                break;
            case 'elite':

                $this->_elite = $value;
                break;
            case 'minor_traits':

                $this->_minorTraitIds = array_map('intval', $value);
                break;
            case 'major_traits':

                $this->_majorTraitIds = array_map('intval', $value);
                break;
            case 'icon':

                $this->_iconUri = $value;
                break;
            case 'background':

                $this->_backgroundUri = $value;
                break;
        }
    }
}