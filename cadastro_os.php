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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <header>
         <h1 id="form-title">Cadastro de Ordem de Serviço</h1>
    </header>
    <main class="container">
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Erro') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="cliente_id">Selecione o cliente:</label>
            <select name="cliente_id" id="cliente_id" required>
                <option value="">Selecione o cliente</option>
                <?php
                $clientes = $pdo->query('SELECT * FROM clientes')->fetchAll(PDO::FETCH_ASSOC);
                foreach ($clientes as $cliente) {
                    echo '<option value="' . htmlspecialchars($cliente['id']) . '">' . htmlspecialchars($cliente['nome']) . '</option>';
                }
                ?>
            </select>

            <label for="tecnico_id">Selecione o técnico:</label>
            <select name="tecnico_id" id="tecnico_id" required>
                <option value="">Selecione o técnico</option>
                <?php
                $tecnicos = $pdo->query('SELECT * FROM tecnicos')->fetchAll(PDO::FETCH_ASSOC);
                foreach ($tecnicos as $tecnico) {
                    echo '<option value="' . htmlspecialchars($tecnico['id']) . '">' . htmlspecialchars($tecnico['nome']) . '</option>';
                }
                ?>
            </select>
        
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" placeholder="Descrição" required></textarea>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="">Selecione o status</option>
                <option value="aberto">Aberto</option>
                <option value="em andamento">Em andamento</option>
                <option value="fechado">Fechado</option>
            </select>

            <label for="tipo_servico">Tipo de Serviço:</label>
            <input type="text" id="tipo_servico" name="tipo_servico" placeholder="Tipo de serviço" required>

            <label for="prioridade">Prioridade:</label>
            <select id="prioridade" name="prioridade" required>
                <option value="">Selecione a prioridade</option>
                <option value="alta">Alta</option>
                <option value="média">Média</option>
                <option value="baixa">Baixa</option>
            </select>

            <label for="prazo">Prazo:</label>
            <input type="date" id="prazo" name="prazo">

            <label for="materiais_utilizados">Materiais Utilizados:</label>
            <textarea id="materiais_utilizados" name="materiais_utilizados" placeholder="Materiais utilizados"></textarea>

            <label for="custos_estimados">Custos Estimados:</label>
            <input type="number" id="custos_estimados" name="custos_estimados" placeholder="Custos estimados" step="0.01">

            <label for="descontos">Descontos:</label>
            <input type="number" id="descontos" name="descontos" placeholder="Descontos" step="0.01">

            <button type="submit">Cadastrar Ordem de Serviço</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
