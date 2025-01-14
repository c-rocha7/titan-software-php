<?php

namespace app\controllers;

use app\classes\BlockNotLogged;
use app\classes\Flash;
use app\interfaces\ControllerInterface;
use app\models\activerecord\FindBy;
use app\models\Usuario;

class Login implements ControllerInterface
{
	public array $data = [];
	public string $view;

	public function __construct()
	{
		BlockNotLogged::block($this, ['store']);
	}


	public function index(array $args)
	{
		$this->view = 'login.php';

		$this->data = [
			'title' => 'Login'
		];
	}

	public function edit(array $args) {}

	public function show(array $args) {}

	public function update(array $args) {}

	public function store()
	{
		$email = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);
		$senha = isset($_POST['senha']) ? htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8') : null;

		$user = new Usuario;
		$userFound = $user->execute(new FindBy(field: 'login', value: $email));

		if (!$userFound) {
			Flash::set('login', 'Usuário ou senha inválidos');

			return redirect('/login');
		}

		if (md5($senha) !== $userFound->senha) {
			Flash::set('login', 'Usuário ou senha inválidos');

			return redirect('/login');
		}

		unset($userFound->senha);

		$_SESSION['user'] = $userFound;

		Flash::set('login', 'Login feito com sucesso');

		return redirect('/painel');
	}

	public function destroy(array $args)
	{
		session_destroy();

		return redirect('/');
	}
}
