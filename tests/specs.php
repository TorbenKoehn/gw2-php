<?php include 'init.php';?>
<!DOCTYPE HTML>
<html lang="<?=$lang?>">
    <head>
        <title>Specializations</title>
        <link rel="stylesheet" href="<?=$api->getFontUri()?>">
        <link rel="stylesheet" href="<?=$api->getItalicFontUri()?>">
        <style>

            html {
                font-family: 'Menomonia', Arial, sans-serif;
                font-size: 14px;
            }

            .spec {
                position: relative;
                overflow: hidden;
                width: 647px;
                height: 135px;
            }

            .spec .background {
                position: absolute;
                bottom: 0;
                left: 0;
            }

            .spec .title {
                position: absolute;
                top: 5px;
                left: 20px;
                color: #fff;
                line-height: 100%;
                font-size: 1.2rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, .2);
            }

            .spec .icon {
                position: absolute;
                top: 50px;
                left: 20px;
            }

            .spec .trait-list {
                position: absolute;
                left: 100px;
                top: 50px;
            }

        </style>
    </head>
    <body>

        <?php foreach ($api->specializations as $spec): ?>
            <div class="spec">
                <img class="background" src="<?=$spec->getBackgroundUri()?>">

                <h1 class="title">
                    <?=$spec->getProfession()?>: <?=$spec->getName()?>
                    <?php if ($spec->isElite()): ?>
                        (Elite)
                    <?php endif; ?>
                </h1>
                <img class="icon" src="<?=$spec->getIconUri()?>">

                <div class="trait-list">
                    <h3 style="display: inline">Major</h3>
                    <?php foreach ($spec->getMajorTraits() as $trait): ?>
                        <img src="<?=$trait->getIconUri()?>" width="32" title="<?=$trait->getName()?> - <?=$trait->getDescription()?>">
                    <?php endforeach; ?>
                    <br>
                    <h3 style="display: inline">Minor</h3>
                    <?php foreach ($spec->getMinorTraits() as $trait): ?>
                        <img src="<?=$trait->getIconUri()?>" width="32" title="<?=$trait->getName()?> - <?=$trait->getDescription()?>">
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endforeach; ?>

    </body>
</html>
