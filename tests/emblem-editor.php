<?php

use GuildWars2\Api\Entity\Character;
use GuildWars2\Api\Entity\Guild\EmblemInfo;

include 'init.php';

function val($name)
{

    return isset($_GET[$name]) ? $_GET[$name] : null;
}

if (isset($_GET['render'])) {

    $bgColor = val('bgColor');
    $primaryColor = val('primaryColor');
    $secondaryColor = val('secondaryColor');
    $foreground = val('foreground');
    $background = val('background');
    $flags = val('flags');
    $flags = $flags ? explode(',', $flags) : [];

    $info = new EmblemInfo(
        $api,
        $background,
        $foreground,
        $flags,
        $bgColor,
        $primaryColor,
        $secondaryColor
    );

    header('Content-Type: image/png; charset=UTF-8');
    imagepng($info->getImage());
    exit;
}


?>
<!DOCTYPE HTML>
<html lang="<?=$lang?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guild Wars 2 Emblem Editor/Creator - (c) 2015 by Torben Köhn</title>
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
            padding-top: 50px;
        }

        .emblem-list {
            text-align: center;
            max-height: 450px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .emblem-layer, .emblem-color {
            transition: all .2s ease-out;
            display: inline-block;
            padding: 2px;
            margin: 2px;
            border: 1px solid white;
        }

        .emblem-layer:hover, .emblem-color:hover {
            background: #efefef;
            cursor: pointer;
            border-color: #e0e0e0;
        }

        .emblem-layer.active, .emblem-color.active {
            background: #ffe0c2;
            cursor: pointer;
            border-color: #e08340;
        }

        .emblem-color .color {
            width: 128px;
            height: 128px;
        }

        .preview {
            min-height: 300px;
            text-align: center;
            padding: 50px;
        }

        .preview img {
            width: 100%;
            height: auto;
        }

    </style>
</head>
<body>

    <div class="container">

        <div class="alert alert-info">
            <strong>
                <i class="fa fa-fw fa-info"></i>
                Hey!
            </strong>
            <p>
                This is <strong>Proof of Concept</strong>-Shit. Don't take it serious, it's not really fast. An emblem editor would best be written in pure JavaScript, not PHP.<br>
                This emblem editor exists to test the <a href="https://github.com/TorbenKoehn/gw2-php" target="_blank">GuildWars 2 PHP API</a>!
            </p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Emblem</h4>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#foreground" aria-controls="foreground" role="tab" data-toggle="tab">
                                    Foreground
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#background" aria-controls="background" role="tab" data-toggle="tab">
                                    Background
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane emblem-list active" id="foreground">
                                <?php foreach ($api->emblemForegrounds as $fg): ?>
                                    <div
                                        class="emblem-layer"
                                        data-foreground="<?=$fg->getId()?>"
                                    >
                                        <img src="<?=$fg->getDataUri()?>" width="128">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane emblem-list" id="background">
                                <?php foreach ($api->emblemBackgrounds as $bg): ?>
                                    <div
                                        class="emblem-layer"
                                        data-background="<?=$bg->getId()?>"
                                    >
                                        <img src="<?=$bg->getDataUri()?>" width="128">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Preview</h4>
                    </div>
                    <div class="panel-body">

                        <strong>Foreground: </strong>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-default" data-flag="FlipForegroundHorizontal">
                                <i class="fa fa-fw fa-arrows-h"></i>
                            </button>
                            <button class="btn btn-default" data-flag="FlipForegroundVertical">
                                <i class="fa fa-fw fa-arrows-v"></i>
                            </button>
                        </div>

                        <strong>Background: </strong>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-default" data-flag="FlipBackgroundHorizontal">
                                <i class="fa fa-fw fa-arrows-h"></i>
                            </button>
                            <button class="btn btn-default" data-flag="FlipBackgroundVertical">
                                <i class="fa fa-fw fa-arrows-v"></i>
                            </button>
                        </div>

                        <div class="preview data-preview">
                            Select an Emblem to get started!
                        </div>



                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Colors</h4>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#primaryColor" aria-controls="primaryColor" role="tab" data-toggle="tab">
                                    Primary
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#secondaryColor" aria-controls="secondaryColor" role="tab" data-toggle="tab">
                                    Secondary
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#bgColor" aria-controls="bgColor" role="tab" data-toggle="tab">
                                    Background
                                </a>
                            </li>
                        </ul>

                        <?php $colors = $api->colors->get(); ?>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane emblem-list active" id="primaryColor">
                                <?php foreach ($colors as $color): ?>
                                    <div
                                        class="emblem-color"
                                        data-primary-color="<?=$color->getId()?>"
                                        >
                                        <div class="color" style="background: <?=$color->getClothRgbValue()?>"></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane emblem-list" id="secondaryColor">
                                <?php foreach ($colors as $color): ?>
                                    <div
                                        class="emblem-color"
                                        data-secondary-color="<?=$color->getId()?>"
                                        >
                                        <div class="color" style="background: <?=$color->getClothRgbValue()?>"></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane emblem-list" id="bgColor">
                                <?php foreach ($colors as $color): ?>
                                    <div
                                        class="emblem-color"
                                        data-bg-color="<?=$color->getId()?>"
                                        >
                                        <div class="color" style="background: <?=$color->getClothRgbValue()?>"></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    $(function() {

        $('.nav-tabs a').click(function() {

            $(this).tab('show');
        });

        var current = {
            foreground: null,
            background: null,
            bgColor: null,
            primaryColor: null,
            secondaryColor: null,
            flags: []
        };

        function render()
        {

            var $img = $('.preview img');

            if ($img.length < 1)
                $img = $('<img>').appendTo($('.preview').empty());

            var pairs = ['render'];

            for (var i in current) {

                if (!current.hasOwnProperty(i))
                    continue;

                if (current[i] !== null)
                    pairs.push(i + '=' + (i === 'flags' ? current[i].join(',') : current[i]));
            }

            $img.attr('src', 'emblem.png?' + pairs.join('&'));
        }

        $('[data-background]').click(function() {

            $('[data-background]').removeClass('active');
            $(this).addClass('active');

            current.background = $(this).data('background');
            render();
        });

        $('[data-foreground]').click(function() {

            $('[data-foreground]').removeClass('active');
            $(this).addClass('active');

            current.foreground = $(this).data('foreground');
            render();
        });

        $('[data-primary-color]').click(function() {

            $('[data-primary-color]').removeClass('active');
            $(this).addClass('active');

            current.primaryColor = $(this).data('primary-color');
            render();
        });

        $('[data-secondary-color]').click(function() {

            $('[data-secondary-color]').removeClass('active');
            $(this).addClass('active');

            current.secondaryColor = $(this).data('secondary-color');
            render();
        });

        $('[data-bg-color]').click(function() {

            $('[data-bg-color]').removeClass('active');
            $(this).addClass('active');

            current.bgColor = $(this).data('bg-color');
            render();
        });

        $('[data-flag]').click(function() {

            var flag = $(this).data('flag');
            if (current.flags.indexOf(flag) !== -1) {

                $(this).removeClass('active');
                current.flags = current.flags.filter(function(val) {

                    return flag !== val;
                });
            } else {

                $(this).addClass('active');
                current.flags.push(flag);
            }

            render();
        });

    });
</script>
</body>
</html>

