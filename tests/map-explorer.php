<?php

use GuildWars2\Api\Entity\Character;

include 'init.php';

function val($name)
{

    return isset($_GET[$name]) ? intval($_GET[$name]) : null;
}


$continentId = val('continent');
$floorId = val('floor');
$regionId = val('region');
$mapId = val('map');
$sectorId = val('sector');
$poiId = val('poi');
$taskId = val('task');


?>
<!DOCTYPE HTML>
<html lang="<?=$lang?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guild Wars 2 Map Explorer - (c) 2015 by Torben Köhn</title>
    <link rel="stylesheet" href="<?=$api->getFontUri()?>">
    <link rel="stylesheet" href="<?=$api->getItalicFontUri()?>">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>

        html, body {
            font-family: 'Menomonia', Arial, sans-serif;
            font-size: 14px;
        }

        body {
            padding-top: 60px;
        }

        .sub-list {
            max-height: 500px;
            overflow-x: hidden;
            overflow-y: auto;
            padding-left: 10px;
        }

    </style>
</head>
<body>

<div class="container">

    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-default">
                <nav>
                    <ul class="nav nav-stacked nav-pills">
                        <?php foreach ($api->continents as $continent): ?>
                            <?php if ($continent->getId() === $continentId): ?>
                                <li class="active">
                                    <a href="map-explorer.php?continent=<?=$continentId?>">
                                        <i class="fa fa-fw fa-map-o"></i>
                                        <?=$continent->getName()?>
                                    </a>
                                    <div class="sub-list">
                                        <ul class="nav nav-pills nav-stacked">
                                            <?php $floors = iterator_to_array($continent->getFloors()); ?>
                                            <?php ksort($floors) ?>
                                            <?php if ($floorId !== null && isset($floors[$floorId])): ?>
                                                <?php $floor = $floors[$floorId] ?>
                                                <li class="active">
                                                    <a href="map-explorer.php?continent=<?=$continentId?>&floor=<?=$floorId?>">
                                                        <i class="fa fa-fw fa-bars"></i>
                                                        Floor <?=$floorId?>
                                                    </a>
                                                    <div class="sub-list">
                                                        <ul class="nav nav-pills nav-stacked">
                                                            <?php $regions = iterator_to_array($floor->getRegions()); ?>
                                                            <?php if ($regionId !== null && isset($regions[$regionId])): ?>
                                                                <?php $region = $regions[$regionId] ?>
                                                                <li class="active">
                                                                    <a href="map-explorer.php?continent=<?=$continentId?>&floor=<?=$floorId?>&region=<?=$regionId?>">
                                                                        <i class="fa fa-fw fa-object-group"></i>
                                                                        <?=$region->getName()?>
                                                                    </a>
                                                                    ...
                                                                </li>
                                                            <?php endif; ?>
                                                            <?php foreach ($regions as $region): ?>
                                                                <?php if ($region->getId() === $regionId) continue; ?>
                                                                <li>
                                                                    <a href="map-explorer.php?continent=<?=$continentId?>&floor=<?=$floorId?>&region=<?=$region->getId()?>">
                                                                        <i class="fa fa-fw fa-object-group"></i>
                                                                        <?=$region->getName()?>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            <?php foreach ($floors as $floor): ?>
                                                <?php if ($floor->getId() === $floorId) continue; ?>
                                                <li>
                                                    <a href="map-explorer.php?continent=<?=$continentId?>&floor=<?=$floor->getId()?>">
                                                        <i class="fa fa-fw fa-bars"></i>
                                                        Floor <?=$floor->getId()?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a href="map-explorer.php?continent=<?=$continent->getId()?>">
                                        <i class="fa fa-fw fa-map-o"></i>
                                        <?=$continent->getName()?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">

                    <?php if ($continentId !== null): ?>

                        <?php $continent = $api->continents->getOne($continentId)?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapseContinent" data-toggle="collapse">
                                        <i class="fa fa-fw fa-map-o"></i>
                                        Continent: <?=$continent->getName()?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseContinent" class="panel-collapse collapse<?=$floorId === null ? ' in' :''?>">
                                <table class="table table-bordered">
                                    <tr><th style="width: 150px">ID:</th><td><?=$continent->getId()?></td></tr>
                                    <tr><th>Name:</th><td><?=$continent->getName()?></td></tr>
                                    <tr><th>Dimensions:</th><td>Width: <?=$continent->getSize()->getX()?>, Height: <?=$continent->getSize()->getY()?></td></tr>
                                    <tr><th>Min. Zoom:</th><td><?=$continent->getMinZoom()?></td></tr>
                                    <tr><th>Max. Zoom:</th><td><?=$continent->getMaxZoom()?></td></tr>
                                    <tr><th>Name:</th><td><?=$continent->getName()?></td></tr>
                                </table>
                            </div>
                        </div>

                        <?php if ($floorId !== null): ?>
                            <?php $floor = $continent->getFloors()->getOne($floorId)?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#collapseFloor" data-toggle="collapse">
                                            <i class="fa fa-fw fa-bars"></i>
                                            Floor: <?=$floorId?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFloor" class="panel-collapse collapse<?=$regionId === null ? ' in' :''?>">
                                    <table class="table table-bordered">
                                        <tr><th style="width: 150px">ID:</th><td><?=$floor->getId()?></td></tr>
                                        <tr><th>Texture Dimensions:</th><td>Width: <?=$floor->getTextureSize()->getX()?>, Height: <?=$floor->getTextureSize()->getY()?></td></tr>
                                    </table>
                                </div>
                            </div>

                            <?php if ($regionId !== null): ?>
                                <?php $region = $floor->getRegions()->getOne($regionId)?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="#collapseRegion" data-toggle="collapse">
                                                <i class="fa fa-fw fa-object-group"></i>
                                                Region: <?=$region->getName()?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFloor" class="panel-collapse collapse<?=$mapId === null ? ' in' :''?>">
                                        <table class="table table-bordered">
                                            <tr><th style="width: 150px">ID:</th><td><?=$floor->getId()?></td></tr>
                                            <tr><th>Label Coord.:</th><td>X: <?=$region->getLabelPosition()->getX()?>, Y: <?=$region->getLabelPosition()->getY()?></td></tr>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    $(function() {


    });
</script>
</body>
</html>

