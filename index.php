<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Bixie\IdealPlugin\IdealPlugin;

$config = json_decode(file_get_contents(__DIR__ . '/vendor/bixie/idealclient/config.json'), true);
$config['root'] = __DIR__;

(new IdealPlugin($config))->run();
