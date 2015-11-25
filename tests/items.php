<?php

use GuildWars2\Api\Entity\Item;

include 'init.php';
ini_set('max_execution_time', 0);
ini_set('xdebug.max_nesting_level', 100000);

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

    <?php foreach ($api->items as $item): ?>

        <div class="item">
            <h1><?=$item->getName()?></h1>
        </div>

    <?php endforeach; ?>

</body>
</html>

