<?php

include 'init.php';

$acc = $api->getAccount();

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

    </style>
</head>
<body>

    <h1><?=$acc->getName()?></h1>
    <table>
        <tr>
            <td>Creation Date</td>
            <td><?=$acc->getCreationDate()->format('Y.m.d')?></td>
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

</body>
</html>

