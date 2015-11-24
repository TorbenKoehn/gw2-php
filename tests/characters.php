<?php

use GuildWars2\Api\Entity\Character;

include 'init.php';
?>
<!DOCTYPE HTML>
<html lang="<?=$lang?>">
<head>
    <title>Account</title>
    <link rel="stylesheet" href="<?=$api->getFontUri()?>">
    <link rel="stylesheet" href="<?=$api->getItalicFontUri()?>">
    <style>

        html {
            font-family: 'Menomonia', Arial, sans-serif;
            font-size: 14px;
        }

        .char {
            background: rgba(0, 0, 255, .1);
            border: 1px solid blue;
            padding: 20px;
        }

    </style>
</head>
<body>

<?php /** @var Character $char */ foreach ($api->characters as $char): ?>

    <div class="char">
        <h1><?=$char->getName()?></h1>
        <h2>Level <?=$char->getLevel()?> <?=$char->getGender()?> <?=$char->getRace()?> <?=$char->getProfession()?></h2>

        <p>
            That retard died <?=$char->getDeathCount()?> times!
        </p>

        <h3>Crafting</h3>
        <table border="1">
            <?php foreach ($char->getCraftingInfos() as $info): ?>
                <tr>
                    <td><?=$info->getDiscipline()?></td>
                    <td><?=$info->getLevel()?></td>
                    <td><?=$info->isActive() ? 'Active' : 'Inactive'?></td>
                </tr>
            <?php endforeach; ?>
        </table>



        <h3>Builds</h3>
        <table border="1">
            <tr>
                <td style="vertical-align: top">
                    <table>
                        <h4>PvP</h4>
                        <?php foreach ($char->getPvpSpecializationInfos() as $info): ?>
                            <?php $spec = $info->getSpecialization(); ?>
                            <tr>
                                <td style="vertical-align: top"><?=$spec->getName()?></td>
                                <td style="vertical-align: top">
                                    <ul>
                                        <?php foreach ($info->getTraits() as $trait): ?>
                                            <li><?=$trait->getName()?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
                <td style="vertical-align: top">
                    <table>
                        <h4>WvW</h4>
                        <?php foreach ($char->getWvwSpecializationInfos() as $info): ?>
                            <?php $spec = $info->getSpecialization(); ?>
                            <tr>
                                <td style="vertical-align: top"><?=$spec->getName()?></td>
                                <td style="vertical-align: top">
                                    <ul>
                                        <?php foreach ($info->getTraits() as $trait): ?>
                                            <li><?=$trait->getName()?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
                <td style="vertical-align: top">
                    <table>
                        <h4>PvE</h4>
                        <?php foreach ($char->getPveSpecializationInfos() as $info): ?>
                            <?php $spec = $info->getSpecialization(); ?>
                            <tr>
                                <td style="vertical-align: top"><?=$spec->getName()?></td>
                                <td style="vertical-align: top">
                                    <ul>
                                        <?php foreach ($info->getTraits() as $trait): ?>
                                            <li><?=$trait->getName()?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        </table>

    </div>

<?php endforeach; ?>

</body>
</html>

