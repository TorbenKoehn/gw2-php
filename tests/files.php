<?php include 'init.php'; ?>
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

<?php foreach ($api->files as $file): ?>

    <div class="file">
        <h1><?=$file->getId()?></h1>
        <img src="<?=$file->getUri()?>">
    </div>

<?php endforeach; ?>

</body>
</html>

