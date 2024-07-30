<?php 
require 'db.php';
$ordens = $pdo->query('SELECT os.numero_os, os.cliente_id, os.tecnico_id, os.data, os.descricao, os.status, c.nome AS cliente, t.nome AS tecnico FROM ordens_de_servico os JOIN clientes c ON os.cliente_id = c.id JOIN tecnicos t ON os.tecnico_id = t.id')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar Ordem de Serviço</title>
    <link rel="stylesheet" type="text/css" href="css/listar_os.css">
</head>
<body>
    <header>
        <h1>Listar Ordem de Serviço</h1>    
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
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
                        <td><?php echo htmlspecialchars($os['data']); ?></td>
                        <td><?php echo htmlspecialchars($os['descricao']); ?></td>
                        <td><?php echo htmlspecialchars($os['status']); ?></td>
                        <td>
                            <a href="atualizar_os.php?id=<?php echo $os['numero_os']; ?>">Editar</a>
                            <a href="excluir_os.php?id=<?php echo $os['numero_os']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta ordem de serviço?');">Excluir</a>
                            <a href="ver_os.php?id=<?php echo $os['numero_os']; ?>">Imprimir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>        
            </tbody>
        </table>
    </main>
</body>
</html>
