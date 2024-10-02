<?php
session_start();
require 'db.php';

// Código para processar o formulário de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Verifica se o usuário já existe
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
    $stmt->execute(['usuario' => $usuario]);

    if ($stmt->rowCount() > 0) {
        $message = 'Usuário já existe. Escolha outro nome de usuário.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)');
        $stmt->execute([
            'usuario' => $usuario,
            'senha' => $senha
        ]);
        $message = 'Usuário adicionado com sucesso';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Novo Usuário</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Incluindo o Bootstrap -->
</head>
<body class="bg-light">
    <header class="text-center py-4">
        <h1>Registrar Novo Usuário</h1>
    </header>
    <main class="container mt-5">
        <section class="bg-white p-4 rounded shadow">
            <?php if (isset($message)): ?>
                <div class="alert <?php echo strpos($message, 'sucesso') !== false ? 'alert-success' : 'alert-danger'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuário:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </section>
    </main>
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Incluindo o JS do Bootstrap -->
</body>
</html>
