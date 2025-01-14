<?php

namespace app\controllers;

use Exception;
use app\classes\BlockNotLogged;
use app\classes\Flash;
use app\classes\Validate;
use app\interfaces\ControllerInterface;
use app\models\activerecord\Delete;
use app\models\activerecord\FindAll;
use app\models\activerecord\FindBy;
use app\models\activerecord\Insert;
use app\models\activerecord\Update;
use app\models\Empresa as EmpresaModel;
use app\models\Funcionario as FuncionarioModel;
use DateTime;

class Funcionario implements ControllerInterface
{
	public array $data = [];
	public string $view;

	public function __construct()
	{
		BlockNotLogged::block($this, ['index', 'edit', 'show', 'update', 'store', 'destroy']);
	}

	public function index(array $args)
	{
		$empresas = (new EmpresaModel)->execute(new FindAll());

		$this->view = 'form_funcionario.php';
		$this->data = [
			'title' => 'Cadastro de Funcionário',
			'empresas' => $empresas
		];
	}

	public function edit(array $args)
	{
		$funcionario = (new FuncionarioModel)->execute(new FindBy(field: 'id_funcionario', value: $args[0]));
		$empresas = (new EmpresaModel)->execute(new FindAll());

		if (!$funcionario) {
			throw new Exception('Funcionário não econtrado');
		}

		$this->view = 'edit_funcionario.php';
		$this->data = [
			'title' => 'Funcionário',
			'funcionario' => $funcionario,
			'empresas' => $empresas
		];
	}

	public function show(array $args)
	{
		$funcionario = (new FuncionarioModel)->execute(new FindBy(field: 'id_funcionario', value: $args[0]));

		if (!$funcionario) {
			throw new Exception('Funcionário não econtrado');
		}

		$this->view = 'funcionario.php';
		$this->data = [
			'title' => 'Funcionário',
			'funcionario' => $funcionario
		];
	}

	public function update(array $args)
	{
		$validate = new Validate();

		$array_validate = [
			'nome' => [REQUIRED, MAXLEN . ':50'],
			'cpf'  => [REQUIRED, CPF],
			'rg'  => [REQUIRED, RG],
			'email'  => [REQUIRED, MAXLEN . ':30'],
			'empresa'  => [REQUIRED]
		];

		if (isset($_POST['salario'])) {
			$array_validate['salario'] = [MAXLEN . ':10'];
		}

		$validate->handle($array_validate);

		if ($validate->errors) {
			return redirect("/funcionario/edit/{$args[0]}");
		}

		$funcionario = new FuncionarioModel;

		if (isset($validate->data['salario'])) {
			$_POST['salario'] = floatval(str_replace(['.', ','], ['', '.'], $_POST['salario']));
			$funcionario->salario = $validate->data['salario'];
			$inEmpresa = $this->calcBonificacao($args);

			if ($inEmpresa >= 1 && $inEmpresa < 5) {
				$funcionario->bonificacao = $funcionario->salario * 0.10;
			}

			if ($inEmpresa >= 5) {
				$funcionario->bonificacao = $funcionario->salario * 0.20;
			}
		}

		$funcionario->nome = $validate->data['nome'];
		$funcionario->cpf = $validate->data['cpf'];
		$funcionario->rg = $validate->data['rg'];
		$funcionario->email = $validate->data['email'];
		$funcionario->id_empresa = $validate->data['empresa'];

		$updated = $funcionario->execute(new Update(field: 'id_funcionario', value: $args[0]));

		if ($updated) {
			Flash::set('updated', 'Funcionário atualizado com sucesso', 'success');
			return redirect('/painel');
		}
	}

	public function store()
	{
		$validate = new Validate();

		$array_validate = [
			'nome' => [REQUIRED, MAXLEN . ':50'],
			'cpf'  => [REQUIRED, CPF],
			'rg'  => [REQUIRED, RG],
			'email'  => [REQUIRED, MAXLEN . ':30'],
			'empresa'  => [REQUIRED]
		];

		if (isset($_POST['salario'])) {
			$_POST['salario'] = floatval(str_replace(['.', ','], ['', '.'], $_POST['salario']));
			$array_validate['salario'] = [MAXLEN . ':10'];
		}

		$validate->handle($array_validate);

		if ($validate->errors) {
			return redirect('/funcionario');
		}

		$funcionario = new FuncionarioModel;
		$funcionario->nome = $validate->data['nome'];
		$funcionario->cpf = $validate->data['cpf'];
		$funcionario->rg = $validate->data['rg'];
		$funcionario->email = $validate->data['email'];
		$funcionario->id_empresa = $validate->data['empresa'];
		$funcionario->data_cadastro = date('Y-m-d');

		if (isset($validate->data['salario'])) {
			$funcionario->salario = $validate->data['salario'];
			$funcionario->bonificacao = 0;
		}

		$created = $funcionario->execute(new Insert);

		if ($created) {
			Flash::set('created', 'Funcionário cadastrado com sucesso!', 'success');
			return redirect('/painel');
		}
	}

	public function destroy(array $args)
	{
		$funcionario = new FuncionarioModel;

		$deleted = $funcionario->execute(new Delete(field: 'id_funcionario', value: $args[0]));

		if ($deleted) {
			Flash::set('deleted', 'Funcionário deletado com sucesso', 'danger');
			return redirect('/painel');
		}
	}

	private function calcBonificacao(array $args)
	{
		$funcionario = (new FuncionarioModel)->execute(new FindBy(field: 'id_funcionario', value: $args[0]));

		$dateNow = new DateTime(date('Y-m-d'));
		$dateFuncionario = new DateTime($funcionario->data_cadastro);

		$diff = $dateNow->diff($dateFuncionario);

		return $diff->y;
	}
}
