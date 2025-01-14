<?php

namespace app\controllers;

use app\classes\BlockNotLogged;
use app\classes\Flash;
use app\classes\Validate;
use app\interfaces\ControllerInterface;
use app\models\activerecord\Insert;
use app\models\Empresa as EmpresaModel;

class Empresa implements ControllerInterface
{
	public array $data = [];
	public string $view;

	public function __construct()
	{
		BlockNotLogged::block($this, ['index', 'edit', 'show', 'update', 'store', 'destroy']);
	}

	public function index(array $args)
	{
		$this->view = 'form_empresa.php';
		$this->data = [
			'title' => 'Empresa',
		];
	}

	public function edit(array $args) {}

	public function show(array $args) {}

	public function update(array $args) {}

	public function store()
	{
		$validate = new Validate();

		$array_validate = [
			'nome' => [REQUIRED, MAXLEN . ':40']
		];

		$validate->handle($array_validate);

		if ($validate->errors) {
			return redirect('/empresa');
		}

		$empresa = new EmpresaModel;
		$empresa->nome = $validate->data['nome'];

		$created = $empresa->execute(new Insert);

		if ($created) {
			Flash::set('created', 'Empresa cadastrada com sucesso!', 'success');
			return redirect('/painel');
		}
	}

	public function destroy(array $args) {}
}
