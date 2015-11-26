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
<div class="container">

    <?php foreach ($acc->getGuilds() as $guild): ?>

        <h1><?=$guild->getName()?></h1>
        <img src="<?=$guild->getEmblemDataUri()?>" width="128">

    <?php endforeach; ?>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

