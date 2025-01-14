<?php

namespace app\core;

use app\interfaces\AppInterface;

class MyApp
{
	private $controller;
	public function __construct(private AppInterface $appInterface) {}

	public function controller()
	{
		$controller = $this->appInterface->controller();
		$method = $this->appInterface->method($controller);
		$params = $this->appInterface->params();

		$this->controller = new $controller;
		$this->controller->$method($params);
	}

	public function view()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			extract($this->controller->data);
			require '../app/views/index.php';
		}
	}
}
