<h2>Lista de Funcionários</h2>

<?= flash('created') ?>
<?= flash('updated') ?>
<?= flash('deleted') ?>
<?= flash('login') ?>
<?= flash('generated') ?>
<?php
if (isset($_SESSION['old'])) {
    unset($_SESSION['old']);
}
?>

<table id="myTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>RG</th>
            <th>E-mail</th>
            <th>Id Empresa</th>
            <th>Data Cadastro</th>
            <th>Salário</th>
            <th>Bonificação</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($funcionarios as $funcionario): ?>
            <tr>
                <td><?= $funcionario->nome ?></td>
                <td><?= $funcionario->cpf ?></td>
                <td><?= $funcionario->rg ?></td>
                <td><?= $funcionario->email ?></td>
                <td><?= $funcionario->nome_empresa ?></td>
                <td><?= date_format(new DateTime($funcionario->data_cadastro), 'd/m/Y') ?></td>
                <td><?= "R$ " . number_format($funcionario->salario, 2, ',', '.') ?></td>
                <td><?= "R$ " . number_format($funcionario->bonificacao, 2, ',', '.') ?></td>
                <td>
                    <a href="/funcionario/edit/<?= $funcionario->id_funcionario ?>">Editar</a> |
                    <a href="/funcionario/destroy/<?= $funcionario->id_funcionario ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button><a href="/pdf">Gerar PDF</a></button>

<script>
    const table = document.getElementById("myTable");
    const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    for (const row of rows) {
        const valor1 = parseFloat(
            row.cells[6].textContent.replace(/[^\d,-]/g, "").replace(",", ".")
        );
        const valor2 = parseFloat(
            row.cells[7].textContent.replace(/[^\d,-]/g, "").replace(",", ".")
        );

        if (!isNaN(valor1) && !isNaN(valor2) && valor2 !== 0) {
            const resultado = (valor2 / valor1) * 100;

            if (resultado === 10) {
                row.style.backgroundColor = "blue";
            } else if (resultado === 20) {
                row.style.backgroundColor = "red";
            }
        }
    }
</script>
