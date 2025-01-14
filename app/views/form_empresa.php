<h2>Formulário de Cadatros de Empresa</h2>

<form action="/empresa/store" method="post">
	<label for="">Nome</label>
	<input type="text" name="nome" value="<?= old('nome') ?>" required>
	<?= flash('nome') ?>

	<button type="submit">Cadatrar</button>
</form>
