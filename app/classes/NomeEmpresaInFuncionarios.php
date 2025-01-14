<?php

namespace app\classes;

class NomeEmpresaInFuncionarios
{
	public static function set(int $id_empresa, array $empresas)
	{
		foreach ($empresas as $empresa) {
			if ($id_empresa === $empresa->id_empresa) {
				return $empresa->nome;
			}
		}
	}
}
