<?php

namespace GuildWars2\Api\Entity\Guild;


use GuildWars2\Api;
use GuildWars2\Api\Entity\Color;
use GuildWars2\Api\Entity\Emblem\Background;
use GuildWars2\Api\Entity\Emblem\Foreground;
use GuildWars2\Api\Entity\Guild;

class EmblemInfo
{

    private $_api;
    private $_backgroundId;
    private $_foregroundId;
    private $_flags;
    private $_backgroundColorId;
    private $_foregroundPrimaryColorId;
    private $_foregroundSecondaryColorId;

    public function __construct(
        Api $api,
        $backgroundId,
        $foregroundId,
        array $flags,
        $backgroundColorId,
        $foregroundPrimaryColorId,
        $foregroundSecondaryColorId
    )
    {

        $this->_api = $api;
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
    public function getApi()
    {
        return $this->_api;
    }

    /**
     * @return mixed
     */
    public function getBackgroundId()
    {
        return $this->_backgroundId;
    }

    /**
     * @return Background
     */
    public function getBackground()
    {

        return $this->_api->emblemBackgrounds->getOne($this->_backgroundId);
    }

    /**
     * @return mixed
     */
    public function getForegroundId()
    {
        return $this->_foregroundId;
    }

    /**
     * @return Foreground
     */
    public function getForeground()
    {

        return $this->_api->emblemForegrounds->getOne($this->_foregroundId);
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

        return $this->_api->colors->getOne($this->_backgroundColorId);
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

        return $this->_api->colors->getOne($this->_foregroundPrimaryColorId);
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

        return $this->_api->colors->getOne($this->_foregroundSecondaryColorId);
    }

    public function loadColors()
    {

        $this->_api->colors->get([
            $this->_backgroundColorId,
            $this->_foregroundPrimaryColorId,
            $this->_foregroundSecondaryColorId
        ]);

        return $this;
    }

    public function getImage(array $backgroundColor = null)
    {

        list($bgR, $bgG, $bgB, $bgA) = ($backgroundColor
            ? array_pad($backgroundColor, 4, 0)
            : [0, 0, 0, 127]
        );

        $img = imagecreatetruecolor(128, 128);
        imagesavealpha($img, true);
        imagealphablending($img, true);

        imagefill($img, 0, 0, imagecolorallocatealpha($img, $bgR, $bgG, $bgB, $bgA));


        if ($this->_backgroundId) {

            $background = $this->getBackground();
            $bgImage = $background->getImage($this->_backgroundColorId ? [
                $this->getBackgroundColor()->getLeatherRgbValue()->getArray()
            ] : null);

            if (in_array('FlipBackgroundHorizontal', $this->_flags))
                imageflip($bgImage, \IMG_FLIP_HORIZONTAL);

            if (in_array('FlipBackgroundVertical', $this->_flags))
                imageflip($bgImage, \IMG_FLIP_VERTICAL);

            imagecopy($img, $bgImage, 0, 0, 0, 0, 128, 128);
            imagedestroy($bgImage);
        }


        if ($this->_foregroundId) {

            $foreground = $this->getForeground();
            $fgImage = $foreground->getImage([
                [0, 0, 0],
                $this->_foregroundPrimaryColorId ? $this->getForegroundPrimaryColor()->getLeatherRgbValue()->getArray() : [255, 0, 0],
                $this->_foregroundSecondaryColorId ? $this->getForegroundSecondaryColor()->getLeatherRgbValue()->getArray() : [0, 0, 255],
                [0, 0, 0]
            ]);

            if (in_array('FlipForegroundHorizontal', $this->_flags))
                imageflip($fgImage, \IMG_FLIP_HORIZONTAL);

            if (in_array('FlipForegroundVertical', $this->_flags))
                imageflip($fgImage, \IMG_FLIP_VERTICAL);

            imagecopy($img, $fgImage, 0, 0, 0, 0, 128, 128);
            imagedestroy($fgImage);
        }

        return $img;
    }

    public function getDataUri()
    {

        $img = $this->getImage();

        ob_start();
        imagepng($img);
        imagedestroy($img);
        $imageData = base64_encode(ob_get_clean());

        return 'data:image/png;base64,'.$imageData;
    }
}