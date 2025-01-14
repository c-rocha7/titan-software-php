<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateRg  implements ValidateInterface
{
	public function handle($field, $param)
	{
		$rg = preg_replace('/[^0-9]/', '', $_POST["{$field}"] ?? '');

		if (strlen($rg) !== 9) {
			return false;
		}
	
		$soma = 0;
		for ($i = 0; $i < 8; $i++) {
			$soma += $rg[$i] * (9 - $i);
		}
	
		$resto = $soma % 11;
		$digitoVerificador = $resto < 2 ? 0 : 11 - $resto;
	
		if ($digitoVerificador == $rg[8]) {
			return false;
		}

		Old::set($field, $rg);

		return $rg;
	}
}
