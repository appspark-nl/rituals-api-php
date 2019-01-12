<?php
require_once __DIR__ . '/../vendor/autoload.php';

use RitualsApi\Rituals;

$ritualsApi = new Rituals('username','password');
$hubs = $ritualsApi->getHubs();

if(count($hubs) > 0) {
    $ritualsApi->turnOn($hubs[0]);
    $ritualsApi->turnOff($hubs[0]);
}