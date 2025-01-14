<!DOCTYPE html>
<html lang="pt_br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $title ?></title>
		<link rel="stylesheet" href="/assets/css/styles.css">
	</head>

	<body>
		<div>

			<section id="header">
				<ul id="nav">
					<li>
						<a href="/<?= (isset($_SESSION['user'])) ? 'painel' : 'home' ?>">Início</a>
					</li>
					<?php if (!isset($_SESSION['user'])): ?>
						<li>
							<a href="/login">Login</a>
						</li>
					<?php endif;?>
					<?php if (isset($_SESSION['user'])): ?>
						<li>
							<a href="/funcionario">Cadastrar Novo Funcionário</a>
						</li>
						<li>
							<a href="/empresa">Cadastrar Nova Empresa</a>
						</li>
					<?php endif;?>
				</ul>

				<div>
					<?= welcome('user') ?>
				</div>
			</section>

			<?php require VIEW_PATH . $this->controller->view ?>
		</div>

		<script src="/assets/js/script.js"></script>

	</body>

</html>
