<?php


namespace Bixie\IdealPlugin;

use Bixie\IdealClient\Exception\IdealClientException;
use Bixie\IdealClient\IdealClient;
use Bixie\IdealClient\IdealClientTransaction;
use Bixie\IdealClient\Utils\Http;
use Bixie\IdealPlugin\View\View;

class IdealPlugin {
	/**
	 * @var IdealClient
	 */
	protected $client;
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * IdealPlugin constructor.
	 * @param $config
	 */
	public function __construct (array $config) {
		$this->config = $config;
		$this->client = new IdealClient($config);

		$this->client->setUpdateCallback(function ($transaction) {
		   	/** @var IdealClientTransaction $transaction */
			//phone home! create request back to server
			$order_params = $transaction->getOrderParams();
			$token = md5($order_params['orderID'] . $order_params['PackagePrice'] . $this->config['shared_pass']);
			Http\idealcheckout_doHttpRequest(
				$transaction->getTransactionNotifyUrl(),
				array_merge([
						'token' => $token,
						'transaction' => $transaction->toArray([], ['order_params'])
					], $order_params)
			);
		});
	}

	/**
	 * @param string $task
	 */
	public function run ($task = 'setup') {
		$task = isset($_GET['task']) ? $_GET['task'] : $task;
		switch ($task) {
			case 'setup':
				//get data
				$dataset = [];
				if (isset($_GET['d']) && $_GET['d'] != '') {
					$dataset = json_decode(base64_decode($_GET['d']), true);
				}
				$notify_url = $this->config['notify_url'];
				$return_url = $dataset['return_url'];
				if (count($dataset)) {
					$transaction = $this->client->createTransaction([
						'order_id' => $dataset['orderID'],
						'transaction_amount' => $dataset['PackagePrice'],
						'transaction_description' => sprintf('Order %s: %s', $dataset['orderID'], $dataset['PackageDescr']),
						'transaction_notify_url' => $notify_url,
						'transaction_payment_url' => $return_url . '?orderID=' . $dataset['orderID'],
						'transaction_success_url' => $return_url . '?orderID=' . $dataset['orderID'] . '&status=SUCCESS',
						'transaction_pending_url' => $return_url . '?orderID=' . $dataset['orderID'] . '&status=PENDING',
						'transaction_failure_url' => $return_url . '?orderID=' . $dataset['orderID'] . '&status=FAILURE',
						'order_params' => $dataset
					]);

					try {

						$result = $this->client->doSetup($transaction);
						if (is_array($result['issuerlist'])) {
							$result['issuerlist'] = $this->getView()->render('issuerlist', $result['issuerlist']);
						}
						$this->renderOutput($this->getView()->render('form', array_merge([
							'order_id' => $transaction->getOrderId(),
							'transaction_amount' => $transaction->getTransactionAmount(),
							'transaction_description' => $transaction->getTransactionDescription()
						], $result->toArray())));

					} catch (IdealClientException $e) {
						$this->renderOutput($e->getMessage());
					}

				} else {

					$this->renderOutput('No data was given');

				}

				break;
			case 'transaction':

				try {

					$result = $this->client->doTransaction();
					$this->renderOutput($this->getView()->render('form', $result->toArray()));

				} catch (IdealClientException $e) {
					$this->renderOutput($e->getMessage());
				}
				break;
			case 'return':

				try {

					$result = $this->client->doReturn();
					$this->renderOutput($this->getView()->render('form', $result->toArray()));

				} catch (IdealClientException $e) {
					$this->renderOutput($e->getMessage());
				}
				break;
			default:
				$this->renderOutput('Task unknown');
				break;
		}

	}

	/**
	 * @return View
	 */
	public function getView () {
		return new View($this->config['root']);
	}

	/**
	 * @param $output
	 */
	public function renderOutput ($output) {
		echo $this->getView()->render('template', compact('output'));
	}

}