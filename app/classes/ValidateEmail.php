<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateEmail  implements ValidateInterface
{
	public function handle($field, $param)
	{
		$isEmail = isset($_POST["{$field}"]) ? filter_var($field, FILTER_SANITIZE_EMAIL) : null;

		if (!$isEmail) {
			Flash::set($field, 'Esse campo tem que ser um email válido!');

			return false;
		}

		$string = filter_var($field, FILTER_SANITIZE_EMAIL);

		Old::set($field, $string);

		return $string;
	}
}
