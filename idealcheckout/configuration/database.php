<?php

$config = json_decode(file_get_contents(__DIR__ . '/../../vendor/bixie/idealclient/config.json'), true);

// MySQL Server/Host
$aSettings['host'] = $config['database']['host'];

// MySQL Username
$aSettings['user'] = $config['database']['user'];

// MySQL Password
$aSettings['pass'] = $config['database']['pass'];

// MySQL Database name
$aSettings['name'] = $config['database']['name'];

// MySQL Table Prefix
$aSettings['prefix'] = $config['database']['prefix'];

// MySQL Engine (MySQL or MySQLi)
$aSettings['type'] = 'mysqli';

