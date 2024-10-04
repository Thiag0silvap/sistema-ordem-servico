<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login
    exit;
}

require 'db.php'; // Inclui o arquivo de conexão com o banco de dados
require('lib/fpdf186/fpdf.php'); // Inclui a biblioteca FPDF

// Função para buscar os dados com base no intervalo de datas
function buscarDadosClientes($pdo, $data_inicio, $data_fim) {
    $stmt = $pdo->prepare("
        SELECT c.nome AS cliente_nome, 
               SUM(o.custos_estimados) AS total_gastos, 
               MONTH(o.data) AS mes, 
               YEAR(o.data) AS ano 
        FROM ordens_de_servico o 
        JOIN clientes c ON o.cliente_id = c.id 
        WHERE o.data BETWEEN :data_inicio AND :data_fim
        GROUP BY c.nome, mes, ano
        ORDER BY c.nome
    ");
    $stmt->execute([
        'data_inicio' => $data_inicio,
        'data_fim' => $data_fim
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para gerar o PDF
function gerarPDF($resultados, $data_inicio, $data_fim) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Relatório de Gastos por Cliente', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, 'Cliente', 1);
    $pdf->Cell(30, 10, 'Mês', 1);
    $pdf->Cell(30, 10, 'Ano', 1);
    $pdf->Cell(50, 10, 'Total Gasto (R$)', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    foreach ($resultados as $row) {
        $pdf->Cell(50, 10, $row['cliente_nome'], 1);
        $pdf->Cell(30, 10, $row['mes'], 1);
        $pdf->Cell(30, 10, $row['ano'], 1);
        $pdf->Cell(50, 10, number_format($row['total_gastos'], 2, ',', '.'), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'relatorio_gastos_clientes.pdf'); // Força o download do PDF
}

// Verifica se o formulário foi enviado
if (isset($_POST['gerar_pdf']) || isset($_POST['filtrar'])) {
    $data_inicio = $_POST['data_inicio'] ?? date('Y-m-01'); // Início do mês atual por padrão
    $data_fim = $_POST['data_fim'] ?? date('Y-m-t'); // Fim do mês atual por padrão

    $resultados = buscarDadosClientes($pdo, $data_inicio, $data_fim);

    if (isset($_POST['gerar_pdf'])) {
        gerarPDF($resultados, $data_inicio, $data_fim);
        exit;
    }
} else {
    // Define datas padrão se o formulário não foi enviado
    $data_inicio = date('Y-m-01');
    $data_fim = date('Y-m-t');
    $resultados = buscarDadosClientes($pdo, $data_inicio, $data_fim);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Relatório de Clientes</title>
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Relatório de Gastos por Cliente</h1>
</header>

<main class="container mt-4">
    <section>
        <h2>Filtrar Gastos Mensais de Clientes</h2>
        <form method="POST" class="mb-4">
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <label for="data_inicio">Data Início</label>
                    <input type="date" class="form-control" name="data_inicio" value="<?php echo htmlspecialchars($data_inicio); ?>" required>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="data_fim">Data Fim</label>
                    <input type="date" class="form-control" name="data_fim" value="<?php echo htmlspecialchars($data_fim); ?>" required>
                </div>
                <div class="col-md-2 mb-3 align-self-end">
                    <button class="btn btn-primary btn-block" name="filtrar" type="submit">Filtrar</button>
                </div>
            </div>
            <button class="btn btn-secondary" name="gerar_pdf" type="submit">Gerar PDF</button>
        </form>

        <h2>Resultados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Mês</th>
                    <th>Ano</th>
                    <th>Total Gasto (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultados): ?>
                    <?php foreach ($resultados as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['cliente_nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['mes']); ?></td>
                            <td><?php echo htmlspecialchars($row['ano']); ?></td>
                            <td><?php echo number_format($row['total_gastos'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Nenhum dado encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<footer class="bg-light text-center py-3 mt-4">
    <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
