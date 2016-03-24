<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Sending data to payment handler</title>
</head>

<body>
<?php

$data_array['orderID']      = '335';
$data_array['FirstName']     = 'Fred';
$data_array['LastName']      = 'Bloggs';
$data_array['email']         = 'fred.bloggs@example.email';
$data_array['PackageNr']     = '6';
$data_array['PackageDescr']  = 'junior registration';
$data_array['PackagePrice']  = '60.00';
$data_array['return_url']  	 = 'send_data.php';

$output            = json_encode($data_array);
$data_string       = 'd='.base64_encode($output);

$targetURL         = 'handler.php';
$targetURLplusData = $targetURL.'?'.$data_string;

?>
<h4>To send an example dataset, click <a href="<?=$targetURLplusData;?>">here</a></h4>
</body>
</html>