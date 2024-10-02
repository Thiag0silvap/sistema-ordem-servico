<?php 
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        header('Location: index.php');
        exit;
    } else {
        $error_message = 'Usuário ou senha inválidos';
    }
} 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Incluindo o Bootstrap -->
</head>
<body class="bg-light">
    <header class="text-center py-4">
        <h1>Sistema de Ordem de Serviço - Login</h1>
    </header>
    <main>
        <section class="container mt-5">
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário:</label>
                            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                <p>Não tem uma conta? <a href="register.php">Registre-se aqui</a></p>
            </div>
        </section>
    </main>
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Incluindo o JS do Bootstrap -->
</body>
</html>
