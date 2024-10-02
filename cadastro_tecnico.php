<?php 
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];

    try {
        $stmt = $pdo->prepare('INSERT INTO tecnicos (nome, especialidade, telefone) VALUES (:nome, :especialidade, :telefone)');
        $stmt->execute([':nome' => $nome, ':especialidade' => $especialidade, ':telefone' => $telefone]);

        $message = 'Técnico cadastrado com sucesso';

    } catch (PDOException $e) {
        $message = 'Erro ao cadastrar técnico: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Técnico</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Incluindo o Bootstrap -->
</head>
<body class="bg-light">
    <header class="text-center py-4">
        <h1>Cadastro de Técnico</h1>
    </header>
    <main class="container mt-5">
        <?php if ($message): ?>
            <div class="alert <?php echo strpos($message, 'Erro') !== false ? 'alert-danger' : 'alert-success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white p-4 rounded shadow">
            <p id="form-description" class="mb-3">Preencha os campos abaixo para cadastrar um novo técnico.</p>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome" required>
            </div>

            <div class="mb-3">
                <label for="especialidade" class="form-label">Especialidade:</label>
                <input type="text" id="especialidade" name="especialidade" class="form-control" placeholder="Especialidade" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" class="form-control" placeholder="Telefone" required>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Técnico</button>
        </form>    
    </main>    
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Incluindo o JS do Bootstrap -->
</body>
</html>
