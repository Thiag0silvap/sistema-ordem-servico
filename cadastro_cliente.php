<?php    
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    try {
        $stmt = $pdo->prepare('INSERT INTO clientes (nome, endereco, telefone) VALUES (:nome, :endereco, :telefone)');
        $stmt->execute([
            ':nome' => $nome,
            ':endereco' => $endereco, 
            ':telefone' => $telefone
        ]);
        $message = 'Cliente registrado com sucesso.';
    } catch (PDOException $e) {
        $message = 'Erro ao registrar cliente: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Incluindo o Bootstrap -->
</head>
<body class="bg-light">
    <header class="text-center py-4">
        <h1>Cadastro de Cliente</h1>
    </header>
    <main>
        <section class="container mt-5" aria-labelledby="form-title">
            <?php if ($message): ?>
                <div class="alert <?php echo strpos($message, 'Erro') !== false ? 'alert-danger' : 'alert-success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" aria-describedby="form-description" class="bg-white p-4 rounded shadow">
                <p id="form-description">Preencha os campos abaixo para cadastrar um novo cliente.</p>
                
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome completo" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Endereço completo" required aria-required="true">
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" placeholder="Número de telefone" required aria-required="true">
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
            </form>
        </section>
    </main>
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Incluindo o JS do Bootstrap -->
</body>
</html>
