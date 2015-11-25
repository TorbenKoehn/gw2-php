<?php

namespace GuildWars2\Api\Entity\Color;

use GuildWars2\Api\Entity\Color;

class Modifier
{

    private $_brightness;
    private $_contrast;
    private $_hue;
    private $_saturation;
    private $_lightness;
    private $_rgbValue;

    public function __construct(
        $brightness,
        $contrast,
        $hue,
        $saturation,
        $lightness,
        RgbValue $rgb
    )
    {

        $this->_brightness = $brightness;
        $this->_contrast = $contrast;
        $this->_hue = $hue;
        $this->_saturation = $saturation;
        $this->_lightness = $lightness;
        $this->_rgbValue = $rgb;
    }

    /**
     * @return mixed
     */
    public function getBrightness()
    {
        return $this->_brightness;
    }

    /**
     * @return mixed
     */
    public function getContrast()
    {
        return $this->_contrast;
    }

    /**
     * @return mixed
     */
    public function getHue()
    {
        return $this->_hue;
    }

    /**
     * @return mixed
     */
    public function getSaturation()
    {
        return $this->_saturation;
    }

    /**
     * @return mixed
     */
    public function getLightness()
    {
        return $this->_lightness;
    }

    /**
     * @return RgbValue
     */
    public function getRgbValue()
    {
        return $this->_rgbValue;
    }
}