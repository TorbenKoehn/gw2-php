<?php

use GuildWars2\Api\Entity\Item;

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

        .file {
            background: rgba(0, 0, 255, .1);
            border: 1px solid blue;
            padding: 20px;
        }

    </style>
</head>
<body>

    <?php /** @var Item $item */ foreach ($api->items as $item): ?>

        <div class="item">
            <h1><?=$item->getName()?></h1>
        </div>

    <?php endforeach; ?>

</body>
</html>

