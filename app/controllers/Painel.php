<?php

namespace app\controllers;

use app\classes\BlockNotLogged;
use app\classes\NomeEmpresaInFuncionarios;
use app\interfaces\ControllerInterface;
use app\models\activerecord\FindAll;
use app\models\Empresa;
use app\models\Funcionario;

class Painel implements ControllerInterface
{
	public array $data = [];
	public string $view;

	public function __construct()
	{
		BlockNotLogged::block($this, ['index', 'edit', 'show', 'update', 'store', 'destroy']);
	}

	public function index(array $args)
	{
		$funcionarios = (new Funcionario)->execute(new FindAll(where: ['ativo' => 1]));
		$empresas = (new Empresa)->execute(new FindAll());

		foreach ($funcionarios as $funcionario) {
			$nameEmpresa = NomeEmpresaInFuncionarios::set($funcionario->id_empresa, $empresas);
			$funcionario->nome_empresa = $nameEmpresa;
		}

		$this->view = 'painel.php';

		$this->data = [
			'title' => 'Painel',
			'funcionarios' => $funcionarios
		];
	}

	public function edit(array $args) {}

	public function show(array $args) {}

	public function update(array $args) {}

	public function store() {}

	public function destroy(array $args) {}
}
