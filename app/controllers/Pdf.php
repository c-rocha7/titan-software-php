<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\GeneratePdf;
use app\classes\NomeEmpresaInFuncionarios;
use app\interfaces\ControllerInterface;
use app\models\activerecord\FindAll;
use app\models\Empresa;
use app\models\Funcionario;

class Pdf implements ControllerInterface
{
	public function index(array $args)
	{
		$funcionarios = (new Funcionario)->execute(new FindAll(where: ['ativo' => 1]));
		$empresas = (new Empresa)->execute(new FindAll());

		foreach ($funcionarios as $funcionario) {
			$nameEmpresa = NomeEmpresaInFuncionarios::set($funcionario->id_empresa, $empresas);
			$funcionario->nome_empresa = $nameEmpresa;
		}

		$generated = GeneratePdf::criarPDF($funcionarios, 'relatorio.pdf');

		if ($generated) {
			Flash::set('generated', 'PDF Gerado com sucesso', 'success');
			return redirect('/painel');
		}
	}

	public function edit(array $args) {}

	public function show(array $args) {}

	public function update(array $args) {}

	public function store() {}

	public function destroy(array $args) {}
}
