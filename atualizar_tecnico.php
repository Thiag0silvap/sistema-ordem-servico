<?php
require 'db.php';

// Verifica se o ID do técnico foi passado pela URL
if (isset($_GET['id'])) {
    $tecnico_id = $_GET['id'];

    // Busca os dados do técnico no banco de dados
    $stmt = $pdo->prepare('SELECT * FROM tecnicos WHERE id = :id');
    $stmt->execute(['id' => $tecnico_id]);
    $tecnico = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o técnico foi encontrado
    if (!$tecnico) {
        echo '<div class="alert alert-danger">Técnico não encontrado</div>';
        exit;
    }
} else {
    echo '<div class="alert alert-danger">ID do técnico não fornecido</div>';
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];

    // Atualiza os dados do técnico no banco de dados
    try {
        $stmt = $pdo->prepare('UPDATE tecnicos SET nome = :nome, especialidade = :especialidade, telefone = :telefone WHERE id = :id');
        $stmt->execute([
            'nome' => $nome,
            'especialidade' => $especialidade,
            'telefone' => $telefone,
            'id' => $tecnico_id
        ]);

        echo '<div class="alert alert-success">Técnico atualizado com sucesso</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Erro ao atualizar técnico: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atualizar Técnico</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Incluindo o Bootstrap -->
</head>
<body class="bg-light">
    <header class="text-center py-4">
        <h1>Atualizar Técnico</h1>
    </header>
    <main class="container mt-5">
        <section aria-labelledby="form-title">
            <h2 id="form-title" class="mb-4">Atualize os dados do técnico</h2>

            <form method="POST" aria-describedby="form-description" class="bg-white p-4 rounded shadow">
                <p id="form-description" class="mb-3">Atualize os dados do técnico nos campos abaixo.</p>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($tecnico['nome']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="especialidade" class="form-label">Especialidade:</label>
                    <input type="text" id="especialidade" name="especialidade" class="form-control" value="<?php echo htmlspecialchars($tecnico['especialidade']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" value="<?php echo htmlspecialchars($tecnico['telefone']); ?>" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Atualizar Técnico</button>
            </form>
        </section>
    </main>
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Incluindo o JS do Bootstrap -->
</body>
</html>
