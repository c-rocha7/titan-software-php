<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateCpf  implements ValidateInterface
{
	public function handle($field, $param)
	{
		$cpf = preg_replace('/\D/', '', $_POST["{$field}"] ?? '');

		if (strlen($cpf) != 11 || preg_match('/^(\d)\1+$/', $cpf)) {
			Flash::set($field, 'CPF Inválido');
			return false;
		}

		for ($t = 9; $t < 11; $t++) {
			$soma = 0;
			for ($i = 0; $i < $t; $i++) {
				$soma += $cpf[$i] * (($t + 1) - $i);
			}
			$resto = $soma % 11;
			$digito = $resto < 2 ? 0 : 11 - $resto;

			if ($cpf[$t] != $digito) {
				Flash::set($field, 'CPF Inválido');
				return false;
			}
		}

		Old::set($field, $cpf);

		return $cpf;
	}
}
