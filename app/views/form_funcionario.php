<h2>Formulário de Cadatros do Funcionário</h2>

<form action="/funcionario/store" method="post">
	<label for="">Nome</label>
	<input type="text" name="nome" value="<?= old('nome') ?>" required>
	<?= flash('nome') ?>

	<label for="">CPF</label>
	<input type="text" name="cpf" value="<?= old('cpf') ?>" maxlength="14" required>
	<?= flash('cpf') ?>

	<label for="">RG</label>
	<input type="text" name="rg" value="<?= old('rg') ?>" maxlength="12" required>
	<?= flash('rg') ?>

	<label for="">Email</label>
	<input type="email" name="email" value="<?= old('email') ?>" required>
	<?= flash('email') ?>

	<label for="">Empresa</label>
	<select name="empresa" required>
		<option value="">Selecione</option>
		<?php foreach ($empresas as $empresa): ?>
			<option value="<?= $empresa->id_empresa ?>" <?= (old('empresa' === $empresa->id_empresa)) ? 'selected' : '' ?>><?= $empresa->nome ?></option>
		<?php endforeach; ?>
	</select>
	<?= flash('empresa') ?>

	<label for="">Salário</label>
	<input type="text" name="salario" id="salario-form_funcionario" value="<?= old('salario') ?>">

	<button type="submit">Cadatrar</button>
</form>

<script>
	document
		.getElementById("salario-form_funcionario")
		.addEventListener("input", (event) => {
			event.target.value = applyCurrencyMask(event.target.value);
		});
</script>
