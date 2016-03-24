<?php

$shared_pass = 'SuperSecr3tPa$$word!!';
$token = $_POST['token'];

if ($token !== md5($_POST['orderID'] . $_POST['PackagePrice'] . $shared_pass)) {
	die('Token not accepted!');
}

echo '<pre>';
var_dump($_POST['transaction']);
echo '</pre>';

