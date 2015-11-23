<?php

namespace GuildWars2\Api\Entity\SpecializationTrait;

abstract class FactBase
{

    private $_text;
    private $_iconUri;

    private $_requiredTraitId;
    private $_overriddenIndex;

    public function __construct($text, $iconUri)
    {

        $this->_text = $text;
        $this->_iconUri = $iconUri;
        $this->_requiredTraitId = null;
        $this->_overriddenIndex = null;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->_text;
    }

    /**
     * @return mixed
     */
    public function getIconUri()
    {
        return $this->_iconUri;
    }

    /**
     * @return null
     */
    public function getRequiredTraitId()
    {
        return $this->_requiredTraitId;
    }

    /**
     * @param null $requiredTraitId
     *
     * @return FactBase
     */
    public function setRequiredTraitId($requiredTraitId)
    {
        $this->_requiredTraitId = $requiredTraitId;

        return $this;
    }

    /**
     * @return null
     */
    public function getOverriddenIndex()
    {
        return $this->_overriddenIndex;
    }

    /**
     * @param null $overriddenIndex
     *
     * @return FactBase
     */
    public function setOverriddenIndex($overriddenIndex)
    {
        $this->_overriddenIndex = $overriddenIndex;

        return $this;
    }
}