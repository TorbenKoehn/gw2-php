<?php

namespace GuildWars2\Api\Entity\Guild;


use GuildWars2\Api\Entity\Color;
use GuildWars2\Api\Entity\Guild;

class EmblemInfo
{

    private $_guild;
    private $_backgroundId;
    private $_foregroundId;
    private $_flags;
    private $_backgroundColorId;
    private $_foregroundPrimaryColorId;
    private $_foregroundSecondaryColorId;

    public function __construct(
        Guild $guild,
        $backgroundId,
        $foregroundId,
        array $flags,
        $backgroundColorId,
        $foregroundPrimaryColorId,
        $foregroundSecondaryColorId
    )
    {

        $this->_guild = $guild;
        $this->_backgroundId = $backgroundId;
        $this->_foregroundId = $foregroundId;
        $this->_flags = $flags;
        $this->_backgroundColorId = $backgroundColorId;
        $this->_foregroundPrimaryColorId = $foregroundPrimaryColorId;
        $this->_foregroundSecondaryColorId = $foregroundSecondaryColorId;
    }

    /**
     * @return Guild
     */
    public function getGuild()
    {
        return $this->_guild;
    }

    /**
     * @return mixed
     */
    public function getBackgroundId()
    {
        return $this->_backgroundId;
    }

    public function getBackground()
    {

        return $this->_guild->getApi()->emblems->getOne($this->_backgroundId);
    }

    /**
     * @return mixed
     */
    public function getForegroundId()
    {
        return $this->_foregroundId;
    }

    public function getForeground()
    {

        return $this->_guild->getApi()->emblems->getOne($this->_foregroundId);
    }

    public function loadImages()
    {

        $this->_guild->getApi()->emblems->get([
            $this->_backgroundId,
            $this->_foregroundId
        ]);

        return $this;
    }

    /**
     * @return array
     */
    public function getFlags()
    {
        return $this->_flags;
    }

    /**
     * @return mixed
     */
    public function getBackgroundColorId()
    {
        return $this->_backgroundColorId;
    }

    /**
     * @return Color
     */
    public function getBackgroundColor()
    {

        return $this->_guild->getApi()->colors->getOne($this->_backgroundColorId);
    }

    /**
     * @return mixed
     */
    public function getForegroundPrimaryColorId()
    {
        return $this->_foregroundPrimaryColorId;
    }

    /**
     * @return Color
     */
    public function getForegroundPrimaryColor()
    {

        return $this->_guild->getApi()->colors->getOne($this->_foregroundPrimaryColorId);
    }

    /**
     * @return mixed
     */
    public function getForegroundSecondaryColorId()
    {
        return $this->_foregroundSecondaryColorId;
    }

    /**
     * @return Color
     */
    public function getForegroundSecondaryColor()
    {

        return $this->_guild->getApi()->colors->getOne($this->_foregroundSecondaryColorId);
    }

    public function loadColors()
    {

        $this->_guild->getApi()->colors->get([
            $this->_backgroundColorId,
            $this->_foregroundPrimaryColorId,
            $this->_foregroundSecondaryColorId
        ]);

        return $this;
    }

    public function load()
    {

        return $this->loadImages()->loadColors();
    }
}