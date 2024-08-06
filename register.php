<?php
session_start();
require 'db.php';

// Código para processar o formulário de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)');
    $stmt->execute([
        'usuario' => $usuario,
        'senha' => $senha
    ]);

    $message = 'Usuário adicionado com sucesso';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Novo Usuário</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <header>
        <h1>Registrar Novo Usuário</h1>
    </header>
    <main>
        <section class="container">
            <?php if (isset($message)): ?>
                <div class="success-message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" placeholder="Usuário" required>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
                <button type="submit">Registrar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
