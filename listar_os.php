<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Verifica se há uma busca por status
$status_filter = '';
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status_filter = $_GET['status'];
}

// Prepara a consulta SQL usando named parameters
$sql = "SELECT o.numero_os, o.data, o.descricao, o.status, c.nome AS cliente, t.nome AS tecnico 
        FROM ordens_de_servico o 
        JOIN clientes c ON o.cliente_id = c.id 
        JOIN tecnicos t ON o.tecnico_id = t.id";

// Adiciona a cláusula WHERE se houver filtro de status
if ($status_filter) {
    $sql .= " WHERE o.status = :status";
}

// Ordena as ordens de serviço pela data
$sql .= " ORDER BY o.data DESC";

$stmt = $pdo->prepare($sql);

// Se houver filtro de status, executa a consulta com o parâmetro nomeado
if ($status_filter) {
    $stmt->execute([':status' => $status_filter]);
} else {
    $stmt->execute();
}

$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Ordens de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Ordens de Serviço</h1>

        <!-- Filtro por status -->
        <form method="GET" class="mb-3">
            <label for="status" class="form-label">Filtrar por Status:</label>
            <select name="status" id="status" class="form-select">
                <option value="">Todos</option>
                <option value="aberta" <?php if ($status_filter == 'aberta') echo 'selected'; ?>>Aberta</option>
                <option value="fechada" <?php if ($status_filter == 'fechada') echo 'selected'; ?>>Fechada</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
        </form>

        <!-- Tabela de ordens de serviço -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Número OS</th>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Técnico</th>
                    <th>Status</th>
                    <th>Descrição</th>
                    <th>Ações</th> <!-- Coluna para os botões de ação -->
                </tr>
            </thead>
            <tbody>
                <?php if ($ordens): ?>
                    <?php foreach ($ordens as $ordem): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ordem['numero_os']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($ordem['data'])); ?></td>
                            <td><?php echo htmlspecialchars($ordem['cliente']); ?></td>
                            <td><?php echo htmlspecialchars($ordem['tecnico']); ?></td>
                            <td><?php echo htmlspecialchars($ordem['status']); ?></td>
                            <td><?php echo htmlspecialchars($ordem['descricao']); ?></td>
                            <td>
                                <!-- Botões de ação -->
                                <a href="atualizar_os.php?id=<?php echo $ordem['numero_os']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="excluir_os.php?id=<?php echo $ordem['numero_os']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                                <a href="ver_os.php?id=<?php echo $ordem['numero_os']; ?>" class="btn btn-sm btn-info">Imprimir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Nenhuma ordem de serviço encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
