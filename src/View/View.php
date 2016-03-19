<?php

namespace Bixie\IdealPlugin\View;


class View {

	protected $template;

	protected $output = '';

	protected $root;

	/**
	 * View constructor.
	 * @param $root
	 */
	public function __construct ($root) {
		$this->root = $root;
	}

	public function render () {
		$output = $this->output;
		if (!file_exists($this->root . $this->template)) {
			echo "No template found";
			return;
		}
		include $this->root . $this->template;
	}

	/**
	 * @return mixed
	 */
	public function getTemplate () {
		return $this->template;
	}

	/**
	 * @param mixed $template
	 * @return View
	 */
	public function setTemplate ($template) {
		$this->template = '/' . ltrim($template, '/');
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOutput () {
		return $this->output;
	}

	/**
	 * @param mixed $output
	 * @return View
	 */
	public function setOutput ($output) {
		$this->output = $output;
		return $this;
	}



}