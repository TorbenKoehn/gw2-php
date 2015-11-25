<?php

use GuildWars2\Api\Entity\Account\AchievementInfo;
use GuildWars2\Api\Entity\Account\BankItemInfo;
use GuildWars2\Api\Entity\Account\DyeInfo;
use GuildWars2\Api\Entity\Account\MaterialInfo;

include 'init.php';

$acc = $api->getAccount();

?>
<!DOCTYPE HTML>
<html lang="<?=$lang?>">
<head>
    <title>Account</title>
    <link rel="stylesheet" href="<?=$api->getFontUri()?>">
    <link rel="stylesheet" href="<?=$api->getItalicFontUri()?>">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <style>

        html {
            font-family: 'Menomonia', Arial, sans-serif;
            font-size: 14px;
        }

    </style>
</head>
<body>

    <div class="row">
        <div class="col-md-4">
            <h1><?=$acc->getName()?></h1>
            <table class="table table-bordered table-striped">
                <tr>
                    <td>Creation Date</td>
                    <td><?=$acc->getCreationDate()->format('d.m.Y')?></td>
                </tr>
                <tr>
                    <td>Access Type</td>
                    <td><?=$acc->getAccessType()?></td>
                </tr>
                <tr>
                    <td>World</td>
                    <td><?=$acc->getWorldId()?></td>
                </tr>
                <tr>
                    <td>Guilds</td>
                    <td>
                        <?=implode('<br>', $acc->getGuildIds())?>
                    </td>
                </tr>
                <tr>
                    <td>Fractal Level</td>
                    <td>
                        <?=$acc->getFractalLevel()?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-md-4">
            <h2>Achievements</h2>
            <div style="max-height: 300px; overflow-y: scroll">
                <table class="table table-bordered table-striped">
                    <?php /** @var AchievementInfo $info */foreach ($acc->getAchievementInfos(true) as $info): ?>
                        <tr>
                            <td>
                                <?php if ($info->getAchievement()->getIconUri()): ?>
                                    <img src="<?=$info->getAchievement()->getIconUri()?>" width="32">
                                <?php endif; ?>
                            </td>
                            <td><?=$info->getAchievement()->getName()?></td>
                            <td>
                                <?php if ($info->getMax() > 0): ?>
                                    <?php $percent = round($info->getCurrent()/$info->getMax()*100, 2); ?>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=$percent?>%"></div>
                                    </div>
                                    <div class="text-center">
                                        <?=$info->getCurrent()?>/<?=$info->getMax()?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?=$info->isDone() ? 'Done' : 'Not done'?></td>
                            <td><?=implode(', ', $info->getBits())?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <h2>Bank Items</h2>
            <div style="max-height: 300px; overflow-y: scroll">
                <table class="table table-bordered table-striped">
                    <?php /** @var BankItemInfo $info */foreach ($acc->getBankItemInfos(true) as $info): ?>
                        <?php if (!$info): ?>
                            <tr><td colspan="3">Empty slot</td></tr>
                        <?php else: ?>
                            <tr>
                                <td>
                                    <?php if ($info->getItem()->getIconUri()): ?>
                                        <img src="<?=$info->getItem()->getIconUri()?>" width="32">
                                    <?php endif; ?>
                                </td>
                                <td><?=$info->getItem()->getName()?></td>
                                <td><?=$info->getAmount()?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <h1>Dyes</h1>
            <div style="max-height: 300px; overflow-y: auto">
                <table class="table table-bordered table-striped">
                    <?php /** @var DyeInfo $info */foreach ($acc->getDyeInfos(true) as $info): ?>
                        <tr>
                            <td>
                                <div style="width: 32px; height: 32px; background: <?=$info->getColor()->getRgbValue('metal')?>"></div>
                            </td>
                            <td><?=$info->getColor()->getName()?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <h2>Materials</h2>
            <div style="max-height: 300px; overflow-y: scroll">
                <table class="table table-bordered table-striped">
                    <?php /** @var MaterialInfo $info */ foreach ($acc->getMaterialInfos(true) as $info): ?>
                        <tr>
                            <td>
                                <?php if ($info->getItem()->getIconUri()): ?>
                                    <img src="<?=$info->getItem()->getIconUri()?>" width="32">
                                <?php endif; ?>
                            </td>
                            <td><?=$info->getItem()->getName()?></td>
                            <td><?=$info->getAmount()?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

