<?php

use GuildWars2\Api\Entity\Account\AchievementInfo;
use GuildWars2\Api\Entity\Account\BankItemInfo;
use GuildWars2\Api\Entity\Account\CurrencyInfo;
use GuildWars2\Api\Entity\Account\DyeInfo;
use GuildWars2\Api\Entity\Account\MaterialInfo;
use GuildWars2\Api\Entity\Account\MiniInfo;
use GuildWars2\Api\Entity\Account\SkinInfo;
use GuildWars2\Api\Entity\Character;

include 'init.php';



?>
<!DOCTYPE HTML>
<html lang="<?=$lang?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account</title>
    <link rel="stylesheet" href="<?=$api->getFontUri()?>">
    <link rel="stylesheet" href="<?=$api->getItalicFontUri()?>">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <style>

        html, body {
            font-family: 'Menomonia', Arial, sans-serif;
            font-size: 14px;
        }

    </style>
</head>
<body>

    <?php $acc = $api->getAccount(); ?>
    <?php $token = $api->getTokenInfo(); ?>
    <div class="container">

        <div class="well well-sm">
            <strong>Token:</strong>
            <span>Key: <em><?=$token->getKey()?></em></span>
            <span>Name: <em><?=$token->getName()?></em></span>
            <span>Permissions: <em><?=implode(', ', $token->getPermissions())?></em></span>
        </div>

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
                        <td><?=$acc->getWorld()->getName()?> (<?=$acc->getWorld()->getPopulation()?>)</td>
                    </tr>
                    <tr>
                        <td>Guilds</td>
                        <td>
                            <?php foreach ($acc->getGuilds() as $guild): ?>
                                <div class="well well-sm">
                                    <?=$guild->getName()?>
                                </div>
                            <?php endforeach; ?>
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
                <h1>Currencies</h1>
                <div style="max-height: 300px; overflow-y: auto">
                    <table class="table table-bordered table-striped">
                        <?php /** @var CurrencyInfo $info */foreach ($acc->getCurrencyInfos(true) as $info): ?>
                            <tr>
                                <td>
                                    <?php if ($info->getCurrency()->getIconUri()): ?>
                                        <img src="<?=$info->getCurrency()->getIconUri()?>" width="32">
                                    <?php endif; ?>
                                </td>
                                <td><?=$info->getCurrency()->getName()?></td>
                                <td><?=$info->getValue()?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

            <div class="col-md-8">
                <h1>Characters</h1>
                <table class="table table-bordered table-striped">
                    <?php /** @var Character $char */foreach ($api->characters->getIndexes() as $name): ?>
                        <?php try { $api->characters->loadOne($name); } catch(\Exception $e) {?>
                            <tr>
                                <td><?=$name?></td>
                                <td colspan="2">
                                    Can't be fetched because of Arena.net bug.<br>
                                    <em><?=htmlentities($e->getMessage(), \ENT_QUOTES)?></em>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php $char = $api->characters->getEntities()[$name]; ?>
                        <?php if (!$char->isFinished()) continue; ?>
                        <tr>
                            <?php $guild = $char->getGuild()?>
                            <td><?=$guild ? '['.$guild->getTag().']' : ''?> <?=$name?></td>
                            <td><?=$char->getLevel()?></td>
                            <td><?=implode(' ', [$char->getGender(), $char->getRace(), $char->getProfession()])?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>



        <div class="row">
            <div class="col-md-3">
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

            <div class="col-md-3">
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

            <div class="col-md-3">
                <h2>Minis</h2>
                <div style="max-height: 300px; overflow-y: scroll">
                    <table class="table table-bordered table-striped">
                        <?php /** @var MiniInfo $info */ foreach ($acc->getMiniInfos(true) as $info): ?>
                            <tr>
                                <td>
                                    <?php if ($info->getMini()->getIconUri()): ?>
                                        <img src="<?=$info->getMini()->getIconUri()?>" width="32">
                                    <?php endif; ?>
                                </td>
                                <td><?=$info->getMini()->getName()?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

            <div class="col-md-3">
                <h2>Skins</h2>
                <div style="max-height: 300px; overflow-y: scroll">
                    <table class="table table-bordered table-striped">
                        <?php /** @var SkinInfo $info */ foreach ($acc->getSkinInfos(true) as $info): ?>
                            <tr>
                                <td>
                                    <?php if ($info->getSkin()->getIconUri()): ?>
                                        <img src="<?=$info->getSkin()->getIconUri()?>" width="32">
                                    <?php endif; ?>
                                </td>
                                <td><?=$info->getSkin()->getName()?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

