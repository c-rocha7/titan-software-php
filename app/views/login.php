<h2>Página de Login</h2>

<form action="/login/store" method="post">
	<label for="">Login</label>
	<input type="text" name="login" id="login" value="teste@gmail.com" required>

	<label for="">Senha</label>
	<input type="password" name="senha" id="senha" value="1234" required>

	<button type="submit">Logar</button>
</form>

<?= flash('login') ?>
