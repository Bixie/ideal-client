<?php

namespace Bixie\IdealPlugin;


use Bixie\IdealClient\Exception\IdealClientException;
use Bixie\IdealClient\IdealClient;
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
				if (count($dataset)) {
					$transaction = $this->client->createTransaction([
						'order_id' => $dataset['orderID'],
						'transaction_amount' => $dataset['PackagePrice'],
						'transaction_description' => sprintf('Order %s: %s', $dataset['orderID'], $dataset['PackageDescr']),
						'order_params' => $dataset
					]);

					try {

						$result = $this->client->doSetup($transaction);
						if (is_array($result['issuerlist'])) {
							$result['issuerlist'] = $this->getView()->render('issuerlist', $result['issuerlist']);
						}
						$this->renderOutput($this->getView()->render('form', $result->toArray()));

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