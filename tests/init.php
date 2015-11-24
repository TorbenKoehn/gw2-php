<?php

include '../vendor/autoload.php';

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'de';
$key = isset($_GET['key']) ? $_GET['key'] : 'BA41D464-FC04-5440-AE69-368E205894C172191723-3EF5-420B-B276-415358D4AB02';

$api = new GuildWars2\Api([
    'lang' => 'de',
    'key' => 'BA41D464-FC04-5440-AE69-368E205894C172191723-3EF5-420B-B276-415358D4AB02'
]);

