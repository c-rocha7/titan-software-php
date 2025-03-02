<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class Validate
{
	public bool $errors = false;
	public array $data = [];

	public function handle(array $validations)
	{
		foreach ($validations as $field => $validation) {
			$this->validateInstance($field, $validation);
		}

		if (in_array(false, $this->data)) {
			$this->errors = true;
		}
	}

	private function validateInstance(string $field, array $validations)
	{
		foreach ($validations as $classValidate) {
			$namespace = "app\\classes\\";

			$class = $namespace . $classValidate;

			[$class, $param] = $this->classWithColomn($class);

			if (class_exists($class)) {
				$this->data[$field] = $this->executeClass(new $class, $field, $param);
			}
		}
	}

	private function classWithColomn($class)
	{
		$param = null;

		if (str_contains($class, ':')) {
			[$class, $param] = explode(':', $class);
		}

		return [$class, $param];
	}

	private function executeClass(ValidateInterface $validateInterface, $field, $param)
	{
		return $validateInterface->handle($field, $param);
	}
}
