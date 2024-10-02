<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';
$sql = "SELECT os.*, c.nome AS cliente_nome, t.nome AS tecnico_nome 
        FROM ordens_de_servico os 
        JOIN clientes c ON os.cliente_id = c.id 
        JOIN tecnicos t ON os.tecnico_id = t.id 
        WHERE 1=1";

// Filtro por Cliente
if (!empty($_GET['cliente'])) {
    $sql .= " AND os.cliente_id = :cliente_id";
    $params[':cliente_id'] = $_GET['cliente'];
}

// Filtro por Técnico
if (!empty($_GET['tecnico'])) {
    $sql .= " AND os.tecnico_id = :tecnico_id";
    $params[':tecnico_id'] = $_GET['tecnico'];
}

// Filtro por Status
if (!empty($_GET['status'])) {
    $sql .= " AND os.status = :status";
    $params[':status'] = $_GET['status'];
}

// Filtro por Data
if (!empty($_GET['data_inicial']) && !empty($_GET['data_final'])) {
    $sql .= " AND os.data BETWEEN :data_inicial AND :data_final";
    $params[':data_inicial'] = $_GET['data_inicial'];
    $params[':data_final'] = $_GET['data_final'];
}

// Prepara e executa a consulta
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar Ordem de Serviço</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-4">
        <h1>Listar Ordem de Serviço</h1>
    </header>

    <main class="container mt-4">
        <!-- Formulário de Filtros -->
        <form method="POST" action="listar_os.php" class="mb-4">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por cliente ou status" value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col">
                    <select class="form-control" name="status">
                        <option value="">Todos os Status</option>
                        <option value="Aberto" <?php if ($status == 'Aberto') echo 'selected'; ?>>Aberto</option>
                        <option value="Fechado" <?php if ($status == 'Fechado') echo 'selected'; ?>>Fechado</option>
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="cliente">
                        <option value="">Todos os Clientes</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>" <?php if ($cliente == $cliente['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cliente['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <input type="date" class="form-control" name="data_inicial" value="<?php echo htmlspecialchars($data_inicial); ?>">
                </div>
                <div class="col">
                    <input type="date" class="form-control" name="data_final" value="<?php echo htmlspecialchars($data_final); ?>">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Botão para Gerar Relatório PDF -->
        <div class="mb-4">
            <a href="gerar_relatorio.php?search=<?php echo $search; ?>&status=<?php echo $status; ?>&cliente=<?php echo $cliente; ?>&data_inicial=<?php echo $data_inicial; ?>&data_final=<?php echo $data_final; ?>" class="btn btn-success">Gerar Relatório PDF</a>
        </div>

        <!-- Tabela de Ordens de Serviço -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Número OS</th>
                    <th>Cliente</th>
                    <th>Técnico</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordens as $os): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($os['numero_os']); ?></td>
                        <td><?php echo htmlspecialchars($os['cliente']); ?></td>
                        <td><?php echo htmlspecialchars($os['tecnico']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($os['data']))); ?></td>
                        <td><?php echo htmlspecialchars($os['descricao']); ?></td>
                        <td><?php echo htmlspecialchars($os['status']); ?></td>
                        <td>
                            <a href="ver_os.php?id=<?php echo $os['numero_os']; ?>" class="btn btn-info">Ver</a>
                            <a href="atualizar_os.php?id=<?php echo $os['numero_os']; ?>" class="btn btn-warning">Editar</a>
                            <a href="excluir_os.php?id=<?php echo $os['numero_os']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta OS?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer class="bg-light text-center py-3">
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>