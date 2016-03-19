<?php

namespace Bixie\IdealPlugin\View;


class View {

	protected $template;

	protected $root;

	/**
	 * View constructor.
	 * @param $root
	 */
	public function __construct ($root) {
		$this->root = $root;
	}

	public function render ($template = null, $vars = []) {
		if ($template) {
			$this->setTemplate($template);
		}
		extract($vars);
		if (!file_exists($this->root . $this->template)) {
			return "No template found";
		}
		ob_start();
		require $this->root . $this->template;

		return ob_get_clean();
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
		$this->template = '/views/' . ltrim($template, '/') . '.php';
		return $this;
	}

}