<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Home</title>
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Sistema de Ordem de Serviço</h1>    
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">SOS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="cadastro_cliente.php">Cadastrar Cliente</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastro_tecnico.php">Cadastrar Técnico</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastro_os.php">Cadastrar Ordem de Serviço</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_clientes.php">Listar Clientes</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_tecnicos.php">Listar Técnicos</a></li>
                <li class="nav-item"><a class="nav-link" href="listar_os.php">Listar Ordens de Serviço</a></li>
                <li class="nav-item"><a class="nav-link" href="relatorio_clientes.php">Relatório de Clientes</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <section>
        <h2>Bem-vindo ao Sistema de Ordem de Serviço</h2>
        <p>Aqui você pode gerenciar suas ordens de serviço de maneira eficiente.</p>
    </section>

    <section class="mt-4">
        <h3>Buscar Ordens de Serviço</h3>
        <form action="index.php" method="POST">
            <div class="input-group mb-3">
                <?php
                // Inicializando as variáveis para evitar erros
                $search = '';
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
                    $search = htmlspecialchars($_POST['search']);
                    // Adicione a lógica de busca aqui, que deve popular a variável $result
                    require 'db.php'; // Certifique-se de incluir sua conexão com o banco de dados
                    $stmt = $pdo->prepare("SELECT * FROM ordens_de_servico WHERE cliente_id LIKE :search OR status LIKE :search");
                    $stmt->execute(['search' => '%' . $search . '%']);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $result = []; // Inicializa como array vazio se não houver resultado
                }
                ?>
                <input type="text" class="form-control" name="search" placeholder="Buscar por cliente ou status" value="<?php echo $search; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
    </section>

    <section class="mt-4">
        <h3>Ordens de Serviço Recentes</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($result)) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['cliente_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($row['data'])) . "</td>";
                        echo "<td><a href='ver_os.php?id=" . $row['id'] . "' class='btn btn-info'>Ver</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma ordem de serviço encontrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</main>

<footer class="bg-light text-center py-3">
    <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
</footer>

<!-- jQuery primeiro, depois Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
