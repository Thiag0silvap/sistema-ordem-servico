<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
$tecnicos = $pdo->query('SELECT * FROM tecnicos')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar Técnicos</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Incluindo o Bootstrap -->
</head>
<body class="bg-light">
<header class="text-center py-4">
    <h1>Listar Técnicos</h1>
</header>
<main class="container mt-5">
    <h2>Técnicos Cadastrados</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Especialidade</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tecnicos as $tecnico): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tecnico['id']); ?></td>
                        <td><?php echo htmlspecialchars($tecnico['nome']); ?></td>
                        <td><?php echo htmlspecialchars($tecnico['especialidade']); ?></td>
                        <td><?php echo htmlspecialchars($tecnico['telefone']); ?></td>
                        <td>
                            <a href="atualizar_tecnico.php?id=<?php echo htmlspecialchars($tecnico['id']); ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="excluir_tecnico.php?id=<?php echo htmlspecialchars($tecnico['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este técnico?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<footer class="text-center py-3 mt-5">
    <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
</footer>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Incluindo o JS do Bootstrap -->
</body>
</html>
