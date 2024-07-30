<?php
include 'db.php';

$os_id = $_GET['id'] ?? null;

if ($os_id) {
    $stmt = $pdo->prepare("SELECT * FROM ordens_de_servico WHERE id = ?");
    $stmt->execute([$os_id]);
    $os = $stmt->fetch();

    if (!$os) {
        $message = "Ordem de serviço não encontrada.";
        $os = null;
    }
} else {
    $message = "ID da ordem de serviço não fornecido.";
    $os = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .ordem-servico {
                border: 1px solid #000;
                padding: 10px;
            }
            .header, .footer {
                text-align: center;
                margin-bottom: 20px;
            }
            .content {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="ordem-servico">
        <div class="header">
            <h1>Ordem de Serviço</h1>
            <?php if ($os): ?>
                <p>Número: <?php echo htmlspecialchars($os['numero_os']); ?></p>
            <?php endif; ?>
        </div>
        <div class="content">
            <?php if ($os): ?>
                <p>Cliente: <?php echo htmlspecialchars($os['cliente_id']); ?></p>
                <p>Técnico: <?php echo htmlspecialchars($os['tecnico_id']); ?></p>
                <p>Descrição: <?php echo htmlspecialchars($os['descricao']); ?></p>
                <p>Status: <?php echo htmlspecialchars($os['status']); ?></p>
            <?php endif; ?>
        </div>
        <div class="footer">
            <p>Obrigado por usar nossos serviços!</p>
        </div>
    </div>
    <?php if (!$os): ?>
        <div class="message error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <button onclick="window.print()">Imprimir</button>
</body>
</html>
