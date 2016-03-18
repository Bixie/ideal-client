<?php
$config = json_decode(file_get_contents(__DIR__ . '/../../vendor/bixie/idealclient/config.json'), true);


// Merchant ID
$aSettings['MERCHANT_ID'] = $config['gateway']['merchant_id'];
// Your iDEAL Sub ID
$aSettings['SUB_ID'] = $config['gateway']['sub_id'];
// Use TEST/LIVE mode; true=TEST, false=LIVE
$aSettings['TEST_MODE'] = $config['gateway']['test'];
// Password used to generate private key file
$aSettings['PRIVATE_KEY_PASS'] = $config['gateway']['private_key_pass'];
// Name of your PRIVATE-KEY-FILE (should be located in /idealcheckout/certificates/)
$aSettings['PRIVATE_KEY_FILE'] = $config['gateway']['private_key'];
// Name of your PRIVATE-CERTIFICATE-FILE (should be located in /idealcheckout/certificates/)
$aSettings['PRIVATE_CERTIFICATE_FILE'] = $config['gateway']['private_cert'];

if (empty($config['gateway']['simulator'])) {
	// ING gateway settings
	$aSettings['GATEWAY_NAME'] = 'ING Bank - iDEAL Advanced';
	$aSettings['GATEWAY_WEBSITE'] = 'http://www.ingbank.nl/';
	$aSettings['GATEWAY_METHOD'] = 'ideal-professional-v3';
	$aSettings['GATEWAY_VALIDATION'] = true;

} else {

	// Basic gateway settings simulator
	$aSettings['GATEWAY_NAME'] = 'iDEAL Simulator - iDEAL';
	$aSettings['GATEWAY_WEBSITE'] = 'http://www.ideal-simulator.nl/';
	$aSettings['GATEWAY_METHOD'] = 'ideal-simulator';
	$aSettings['GATEWAY_VALIDATION'] = false;
}
