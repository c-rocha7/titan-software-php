<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateRequired  implements ValidateInterface
{
	public function handle($field, $param)
	{
		$string = isset($_POST["{$field}"]) ? htmlspecialchars($_POST["{$field}"], ENT_QUOTES, 'UTF-8') : null;

		if ($string === '') {
			Flash::set($field, 'O campo é obrigatório!');

			return false;
		}

		Old::set($field, $string);

		return $string;
	}
}
