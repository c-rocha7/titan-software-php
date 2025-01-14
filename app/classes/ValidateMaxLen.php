<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateMaxLen  implements ValidateInterface
{
	public function handle($field, $param)
	{
		$string = isset($_POST["{$field}"]) ? htmlspecialchars($_POST["{$field}"], ENT_QUOTES, 'UTF-8') : null;

		if (strlen($string) > $param) {
			Flash::set($field, "O campo não pode ter mais que {$param} caracteres!");

			return false;
		}

		Old::set($field, $string);

		return $string;
	}
}
