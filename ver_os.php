<?php
require 'db.php'; // Inclui o arquivo de conexão com o banco de dados

// Obtém o ID da ordem de serviço a partir da URL
$id = $_GET['id'] ?? null;

// Verifica se o ID foi fornecido
if (!$id) {
    echo "Ordem de serviço não encontrada!";
    exit;
}

// Prepara e executa a consulta para obter os detalhes da ordem de serviço
$stmt = $pdo->prepare('SELECT os.*, c.nome AS cliente_nome, t.nome AS tecnico_nome, c.endereco AS cliente_endereco, c.telefone AS cliente_telefone, t.especialidade AS tecnico_especialidade, t.telefone AS tecnico_telefone FROM ordens_de_servico os JOIN clientes c ON os.cliente_id = c.id JOIN tecnicos t ON os.tecnico_id = t.id WHERE os.numero_os = ?');
$stmt->execute([$id]);
$os = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se a ordem de serviço foi encontrada
if (!$os) {
    echo "Ordem de serviço não encontrada!";
    exit;
}

$data_formatada = (new DateTime($os['data']))->format('d/m/Y');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Ver Ordem de Serviço</title>
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Detalhes da Ordem de Serviço</h1>
</header>
<main class="container mt-4">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Número da OS: <?php echo htmlspecialchars($os['numero_os']); ?></h5>
        </div>
        <div class="card-body">
            <h4 class="card-title">Informações do Cliente</h4>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($os['cliente_nome']); ?></p>
            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($os['cliente_endereco']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($os['cliente_telefone']); ?></p>
            
            <hr>

            <h4 class="card-title">Detalhes do Técnico</h4>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($os['tecnico_nome']); ?></p>
            <p><strong>Especialidade:</strong> <?php echo htmlspecialchars($os['tecnico_especialidade']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($os['tecnico_telefone']); ?></p>

            <hr>

            <h4 class="card-title">Detalhes do Serviço</h4>
            <p><strong>Data:</strong> <?php echo htmlspecialchars($data_formatada); ?></p>
            <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($os['descricao'])); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($os['status']); ?></p>
            <p><strong>Tipo de Serviço:</strong> <?php echo htmlspecialchars($os['tipo_servico']); ?></p>
            <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($os['prioridade']); ?></p>
            <p><strong>Prazo:</strong> <?php echo htmlspecialchars($os['prazo']); ?></p>
            <p><strong>Materiais Utilizados:</strong> <?php echo nl2br(htmlspecialchars($os['materiais_utilizados'])); ?></p>
            <p><strong>Custos Estimados:</strong> <?php echo htmlspecialchars($os['custos_estimados']); ?></p>
            <p><strong>Descontos:</strong> <?php echo htmlspecialchars($os['descontos']); ?></p>
        </div>
    </div>

    <div class="text-center">
        <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
    </div>
</main>
<footer class="bg-light text-center py-3 mt-4">
    <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
