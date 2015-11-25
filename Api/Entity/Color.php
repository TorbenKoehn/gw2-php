<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\Color\Modifier;
use GuildWars2\Api\Entity\Color\RgbValue;
use GuildWars2\Api\SetEntityBase;

class Color extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_rgbValue;
    /**
     * @var Modifier[]
     */
    private $_modifiers;
    private $_itemId;
    private $_categories;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_rgbValue = null;
        $this->_modifiers = [];
        $this->_itemId = null;
        $this->_categories = [];
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
    public function getRgbValue($modifier = null)
    {

        if ($modifier) {

            return $this->_modifiers[$modifier]->getRgbValue();
        }

        return $this->_rgbValue;
    }

    /**
     * @return mixed
     */
    public function getModifiers()
    {
        return $this->_modifiers;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->_itemId;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->_categories;
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
            case 'base_rgb':

                $this->_rgbValue = new RgbValue(
                    $value[0],
                    $value[1],
                    $value[2]
                );
                break;
            case 'cloth':
            case 'leather':
            case 'metal':

                $this->_modifiers[$key] = new Modifier(
                    $value['brightness'],
                    $value['contrast'],
                    $value['hue'],
                    $value['saturation'],
                    $value['lightness'],
                    new RgbValue(
                        $value['rgb'][0],
                        $value['rgb'][1],
                        $value['rgb'][2]
                    )
                );
                break;
            case 'item':

                $this->_itemId = $value;
                break;
            case 'categories':

                $this->_categories = $value;
                break;
        }
    }
}