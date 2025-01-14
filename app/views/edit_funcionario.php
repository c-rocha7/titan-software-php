<h2>Formulário de Edição do Funcionário</h2>

<form action="/funcionario/update/<?= $funcionario->id_funcionario ?>" method="post">
	<label for="">Nome</label>
	<input type="text" name="nome" value="<?= $funcionario->nome ?>" required>

	<label for="">CPF</label>
	<input type="text" name="cpf" value="<?= $funcionario->cpf ?>" required>

	<label for="">RG</label>
	<input type="text" name="rg" value="<?= $funcionario->rg ?>" required>

	<label for="">Email</label>
	<input type="email" name="email" value="<?= $funcionario->email ?>" required>

	<label for="">Empresa</label>
	<select name="empresa" required>
		<option value="">Selecione</option>
		<?php foreach ($empresas as $empresa): ?>
			<option value="<?= $empresa->id_empresa ?>" <?= ($funcionario->id_empresa === $empresa->id_empresa) ? 'selected' : '' ?>><?= $empresa->nome ?></option>
		<?php endforeach; ?>
	</select>

	<label for="">Salário</label>
	<input type="text" name="salario" id="salario-edit_funcionario" value="<?= $funcionario->salario ?>">

	<button type="submit">Editar</button>
</form>

<script>
	document
		.getElementById("salario-edit_funcionario")
		.addEventListener("input", (event) => {
			event.target.value = applyCurrencyMask(event.target.value);
		});
</script>
