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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/listar.css">
</head>
<body>
<header>
    <h1>Listar Técnicos</h1>
</header>
<main class="container">
    <h2>Técnicos Cadastrados</h2>
    <table>
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
                            <a href="atualizar_tecnico.php?id=<?php echo htmlspecialchars($tecnico['id']); ?>">Editar</a>
                            <form method="POST" action="excluir_tecnico.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tecnico['id']); ?>">
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este técnico?');">Excluir</button>
                            </form>
                        </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<footer>
    <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
</footer>
</body>
</html>
