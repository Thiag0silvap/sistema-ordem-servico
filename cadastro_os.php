<?php 
require 'db.php';

$message = '';
function gerarNumeroOS($pdo) {
    do {
        // Gera um número aleatório de 6 dígitos
        $numero_os = mt_rand(100000, 999999);
        // Verifica se o número já existe
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM ordens_de_servico WHERE numero_os = ?');
        $stmt->execute([$numero_os]);
        $count = $stmt->fetchColumn();
    } while ($count > 0);
    return $numero_os;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $tecnico_id = $_POST['tecnico_id'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];
    $numero_os = gerarNumeroOS($pdo);

    try {
        $stmt = $pdo->prepare('INSERT INTO ordens_de_servico (numero_os, cliente_id, tecnico_id, data, descricao, status) VALUES (:numero_os, :cliente_id, :tecnico_id, :data, :descricao, :status)');
        $stmt->execute([':numero_os' => $numero_os, ':cliente_id' => $cliente_id, ':tecnico_id' => $tecnico_id, ':data' => $data, ':descricao' => $descricao, ':status' => $status]);
        $message = 'Ordem de serviço registrada com sucesso. Número da OS: ' . $numero_os;
    } catch (PDOException $e) {
        $message = 'Erro ao registrar ordem de serviço: ' . $e->getMessage();
    }
} 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Ordem de Serviço</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Incluindo o Bootstrap -->
</head>
<body class="bg-light">
    <header class="text-center py-4">
        <h1>Cadastro de Ordem de Serviço</h1>
    </header>
    <main class="container mt-5">
        <?php if ($message): ?>
            <div class="alert <?php echo strpos($message, 'Erro') !== false ? 'alert-danger' : 'alert-success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white p-4 rounded shadow">
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Selecione o cliente:</label>
                <select name="cliente_id" id="cliente_id" class="form-select" required>
                    <option value="">Selecione o cliente</option>
                    <?php
                    $clientes = $pdo->query('SELECT * FROM clientes')->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($clientes as $cliente) {
                        echo '<option value="' . htmlspecialchars($cliente['id']) . '">' . htmlspecialchars($cliente['nome']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="tecnico_id" class="form-label">Selecione o técnico:</label>
                <select name="tecnico_id" id="tecnico_id" class="form-select" required>
                    <option value="">Selecione o técnico</option>
                    <?php
                    $tecnicos = $pdo->query('SELECT * FROM tecnicos')->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($tecnicos as $tecnico) {
                        echo '<option value="' . htmlspecialchars($tecnico['id']) . '">' . htmlspecialchars($tecnico['nome']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        
            <div class="mb-3">
                <label for="data" class="form-label">Data:</label>
                <input type="date" id="data" name="data" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" placeholder="Descrição" required></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="">Selecione o status</option>
                    <option value="aberto">Aberto</option>
                    <option value="em andamento">Em andamento</option>
                    <option value="fechado">Fechado</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tipo_servico" class="form-label">Tipo de Serviço:</label>
                <input type="text" id="tipo_servico" name="tipo_servico" class="form-control" placeholder="Tipo de serviço" required>
            </div>

            <div class="mb-3">
                <label for="prioridade" class="form-label">Prioridade:</label>
                <select id="prioridade" name="prioridade" class="form-select" required>
                    <option value="">Selecione a prioridade</option>
                    <option value="alta">Alta</option>
                    <option value="média">Média</option>
                    <option value="baixa">Baixa</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="prazo" class="form-label">Prazo:</label>
                <input type="date" id="prazo" name="prazo" class="form-control">
            </div>

            <div class="mb-3">
                <label for="materiais_utilizados" class="form-label">Materiais Utilizados:</label>
                <textarea id="materiais_utilizados" name="materiais_utilizados" class="form-control" placeholder="Materiais utilizados"></textarea>
            </div>

            <div class="mb-3">
                <label for="custos_estimados" class="form-label">Custos Estimados:</label>
                <input type="number" id="custos_estimados" name="custos_estimados" class="form-control" placeholder="Custos estimados" step="0.01">
            </div>

            <div class="mb-3">
                <label for="descontos" class="form-label">Descontos:</label>
                <input type="number" id="descontos" name="descontos" class="form-control" placeholder="Descontos" step="0.01">
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Ordem de Serviço</button>
        </form>
    </main>
    <footer class="text-center py-3 mt-5">
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Incluindo o JS do Bootstrap -->
</body>
</html>
