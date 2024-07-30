<?php
include 'db.php';

// Verificar se o ID foi passado
if (!isset($_GET['id'])) {
    die("ID não fornecido.");
}

$os_numero = $_GET['id'];

// Preparar e executar a consulta
$stmt = $pdo->prepare("SELECT os.*, c.nome AS cliente_nome, t.nome AS tecnico_nome FROM ordens_de_servico os JOIN clientes c ON os.cliente_id = c.id JOIN tecnicos t ON os.tecnico_id = t.id WHERE os.numero_os = ?");
$stmt->execute([$os_numero]);
$os = $stmt->fetch();

// Verificar se a ordem de serviço foi encontrada
if (!$os) {
    die("Nenhuma ordem de serviço encontrada para o número: " . htmlspecialchars($os_numero));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Imprimir Ordem de Serviço</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .ordem-servico {
            border: 1px solid #000;
            padding: 10px;
            max-width: 800px;
            margin: 0 auto;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-top: 20px;
        }
        @media print {
            body {
                margin: 0;
            }
            .ordem-servico {
                border: none;
            }
            button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <article class="ordem-servico">
        <header class="header">
            <h1>Ordem de Serviço</h1>
            <p>Número: <?php echo htmlspecialchars($os['numero_os']); ?></p>
        </header>
        <section class="content">
            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($os['cliente_nome']); ?></p>
            <p><strong>Técnico:</strong> <?php echo htmlspecialchars($os['tecnico_nome']); ?></p>
            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($os['descricao']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($os['status']); ?></p>
        </section>
        <footer class="footer">
            <p>Obrigado por usar nossos serviços!</p>
        </footer>
    </article>
    <button onclick="window.print()">Imprimir</button>
</body>
</html>
