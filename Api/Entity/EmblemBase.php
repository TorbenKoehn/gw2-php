<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\SetEntityBase;

abstract class EmblemBase extends SetEntityBase
{

    private $_id;
    private $_layers;

    protected function init()
    {

        $this->_id = null;
        $this->_layers = [];
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
    public function getLayers()
    {
        return $this->_layers;
    }

    public function downloadLayers($bodyAsString = false)
    {

        foreach ($this->_layers as $uri)
            yield $this->getApi()->download($uri, $bodyAsString);
    }

    public function getLayerImages()
    {

        foreach ($this->downloadLayers(true) as $layer) {

            $img = imagecreatefromstring($layer);
            yield $img;
        }
    }

    public function getImage($layerColors = null)
    {

        $layerColors = $layerColors ? $layerColors : [
            [0, 0, 0],
            [255, 0, 0],
            [0, 0, 255],
            [0, 255, 0],
            [127, 127, 127]
        ];

        $img = imagecreatetruecolor(128, 128);
        imagealphablending($img, true);
        imagesavealpha($img, true);

        $alpha = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $alpha);

        //Merge all layers into this image
        $i = 0;
        foreach ($this->getLayerImages() as $layer) {


            list($r, $g, $b) = $layerColors[$i++];

            imagefilter($layer, IMG_FILTER_BRIGHTNESS, -255);
            imagefilter($layer, IMG_FILTER_COLORIZE, $r, $g, $b);

            imagecopy($img, $layer, 0, 0, 0, 0, 128, 128);
            imagedestroy($layer);
        }

        return $img;
    }

    public function getDataUri($layerColors = null)
    {

        $img = $this->getImage($layerColors);
        ob_start();
        imagepng($img);
        imagedestroy($img);
        $imageData = base64_encode(ob_get_clean());

        return 'data:image/png;base64,'.$imageData;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = $value;
                break;
            case 'layers':

                $this->_layers = $value;
                break;
        }
    }
}