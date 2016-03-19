<?php

namespace Bixie\IdealPlugin;


use Bixie\IdealClient\Exception\IdealClientException;
use Bixie\IdealClient\IdealClient;
use Bixie\IdealPlugin\View\View;

class IdealPlugin {

	protected $client;

	protected $view;

	protected $config;

	/**
	 * IdealPlugin constructor.
	 * @param $config
	 */
	public function __construct (array $config) {
		$this->config = $config;
		$this->client = new IdealClient($config);
		$this->view = (new View($config['root']))->setTemplate('views/template.php');
	}

	public function run ($task = 'setup') {
		$task = isset($_GET['task']) ? $_GET['task'] : $task;
		switch ($task) {
			case 'setup':
				//get data
				$dataset = [];
				if (isset($_GET['d']) && $_GET['d'] != '') {
					$dataset = json_decode(base64_decode($_GET['d']), true);
				}
				if (count($dataset)) {
					$transaction = $this->client->createTransaction([
						'order_id' => $dataset['orderID'],
						'transaction_amount' => $dataset['PackagePrice'],
						'transaction_description' => sprintf('Order %s: %s', $dataset['orderID'], $dataset['PackageDescr']),
						'order_params' => $dataset
					]);

					try {

						$result = $this->client->doSetup($transaction->getOrderId(), $transaction->getOrderCode());
						$this->renderOutput($result['output']);

					} catch (IdealClientException $e) {
						$this->renderOutput($e->getMessage());
					}

				} else {

					$this->renderOutput('No data was given');

				}

				break;
			case 'return':

				try {

					$result = $this->client->doReturn();
					$this->renderOutput($result['output']);

				} catch (IdealClientException $e) {
					$this->renderOutput($e->getMessage());
				}
				break;
			default:
				$this->renderOutput('Task unknown');
				break;
		}

	}

	public function renderOutput ($output) {
		$this->view->setOutput($output)->render();
	}

}