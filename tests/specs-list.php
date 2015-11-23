<?php

use GuildWars2\Api\Entity\Specialization;
use GuildWars2\Api\Entity\SpecializationTrait;
use GuildWars2\Api\Entity\SpecializationTrait\FactBase;

include 'init.php';

ini_set('max_execution_time', 0);

?>
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
            background: rgba(255, 0, 0, .1);
            border: 1px solid red;
            padding: 10px;
        }

        .trait {
            background: rgba(0, 255, 0, .1);
            border: 1px solid green;
            padding: 10px;
        }

        .fact {
            background: rgba(0, 0, 255, .1);
            border: 1px solid blue;
            padding: 10px;
        }

    </style>
</head>
<body>

<?php /** @var Specialization $spec */foreach ($api->specializations as $spec): ?>
    <div class="spec">

        <h1 class="title">
            <?=$spec->getProfession()?>: <?=$spec->getName()?>
            <?php if ($spec->isElite()): ?>
                (Elite)
            <?php endif; ?>
        </h1>

        <div class="trait-list">
            <h2>Major Traits</h2>
            <?php /** @var SpecializationTrait $trait */ foreach ($spec->getMajorTraits() as $trait): ?>
                <div class="trait">
                    <h3><?=$trait->getName()?></h3>
                    <p><?=$trait->getDescription()?></p>
                    <h4>Facts</h4>
                    <?php /** @var FactBase $fact */ foreach ($trait->getFacts() as $fact): ?>
                        <div class="fact">
                            <h5><?=basename(get_class($fact))?></h5>
                            <p><?=$fact->getText()?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <h2>Minor Traits</h2>
            <?php /** @var SpecializationTrait $trait */ foreach ($spec->getMinorTraits() as $trait): ?>
                <div class="trait">
                    <h3><?=$trait->getName()?></h3>
                    <p><?=$trait->getDescription()?></p>
                    <h4>Facts</h4>
                    <?php /** @var FactBase $fact */ foreach ($trait->getFacts() as $fact): ?>
                        <div class="fact">
                            <h5><?=basename(get_class($fact))?></h5>
                            <p><?=$fact->getText()?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
<?php endforeach; ?>

</body>
</html>
