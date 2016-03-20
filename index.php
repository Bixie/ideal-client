<?php
//@ini_set('display_errors', 1);
//@error_reporting(E_ALL);
//@ini_set('log_errors', 1);

require_once(__DIR__ . '/vendor/autoload.php');

use Bixie\IdealPlugin\IdealPlugin;

$config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);
$config['root'] = __DIR__;

(new IdealPlugin($config))->run();
