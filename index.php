<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Bixie\IdealClient\IdealClient;
use Bixie\IdealClient\Exception\IdealClientException;


$dataset = [];
if (isset($_GET['d']) && $_GET['d'] != '') {
	$dataset = json_decode(base64_decode($_GET['d']), true);
}

//if (!count($dataset)) { //always give some test data for now
//
//	$dataset['orderID']       = '646';
//	$dataset['FirstName']     = 'Fred';
//	$dataset['LastName']      = 'Bloggs';
//	$dataset['email']         = 'fred.bloggs@example.email';
//	$dataset['PackageNr']     = '6';
//	$dataset['PackageDescr']  = 'junior registration';
//	$dataset['PackagePrice']  = '60.00';
//
//}

$task = isset($_GET['task']) ? $_GET['task'] : 'setup';

$config = json_decode(file_get_contents(__DIR__ . '/vendor/bixie/idealclient/config.json'), true);

try {

	$client = new IdealClient($config);

	switch ($task) {
		case 'setup':

			if (count($dataset)) {
				$transaction = $client->createTransaction([
					'order_id' => $dataset['orderID'],
					'transaction_amount' => $dataset['PackagePrice'],
					'transaction_description' => sprintf('Order %s: %s', $dataset['orderID'], $dataset['PackageDescr']),
					'order_params' => $dataset
				]);

				$client->doSetup($transaction->getOrderId(), $transaction->getOrderCode());

			} else {

				echo 'No data was given';

			}

			break;
		case 'return':

			$client->doReturn();

			break;
		default:
			echo 'Task unknown';
			break;
	}


} catch (IdealClientException $e) {

	echo $e->getMessage();

}


