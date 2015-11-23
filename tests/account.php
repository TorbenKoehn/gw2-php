<?php

include '../vendor/autoload.php';

$api = new GuildWars2\Api([
    'lang' => 'de',
    'key' => 'BA41D464-FC04-5440-AE69-368E205894C172191723-3EF5-420B-B276-415358D4AB02'
]);


var_dump($api->characters->getOne('Elfalina'));