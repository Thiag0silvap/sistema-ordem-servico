<?php 
require 'db.php';

$numero_os = $_GET['id']; // Utilize 'numero_os' em vez de 'id'
$stmt = $pdo->prepare('SELECT * FROM ordens_de_servico WHERE numero_os = ?');
$stmt->execute([$numero_os]);
$os = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$os) {
    echo "Ordem de serviço não encontrada!";
    exit;
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $tecnico_id = $_POST['tecnico_id'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare('UPDATE ordens_de_servico SET cliente_id = ?, tecnico_id = ?, data = ?, descricao = ?, status = ? WHERE numero_os = ?');
        $stmt->execute([$cliente_id, $tecnico_id, $data, $descricao, $status, $numero_os]);

        $message = 'Ordem de serviço atualizada com sucesso';
    } catch (PDOException $e) {
        $message = 'Erro ao atualizar ordem de serviço: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atualizar Ordem de Serviço</title>
    <link rel="stylesheet" href="css/styles.css"> 
    <link rel="stylesheet" href="css/cadastro.css">
</head> 
<body>
    <header>
        <h1>Atualizar Ordem de Serviço</h1>
    </header>
    <main>
        <?php if (isset($message)): ?>
            <div class="message <?php echo strpos($message, 'Erro') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST"> 
            <label for="cliente_id">Cliente:</label>
            <select name="cliente_id" required>
                <?php
                $clientes = $pdo->query('SELECT * FROM clientes')->fetchAll(PDO::FETCH_ASSOC);
                foreach ($clientes as $cliente) {
                    $selected = $cliente['id'] == $os['cliente_id'] ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($cliente['id']) . '" ' . $selected . '>' . htmlspecialchars($cliente['nome']) . '</option>';
                }
                ?>
            </select>

            <label for="tecnico_id">Técnico:</label>
            <select name="tecnico_id" required>
                <?php
                $tecnicos = $pdo->query('SELECT * FROM tecnicos')->fetchAll(PDO::FETCH_ASSOC);
                foreach ($tecnicos as $tecnico) {
                    $selected = $tecnico['id'] == $os['tecnico_id'] ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($tecnico['id']) . '" ' . $selected . '>' . htmlspecialchars($tecnico['nome']) . '</option>';
                }
                ?>
            </select>

            <label for="data">Data:</label>
            <input type="date" name="data" value="<?php echo htmlspecialchars($os['data']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" required><?php echo htmlspecialchars($os['descricao']); ?></textarea>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="aberto" <?php echo $os['status'] == 'aberto' ? 'selected' : ''; ?>>Aberto</option>
                <option value="em andamento" <?php echo $os['status'] == 'em andamento' ? 'selected' : ''; ?>>Em andamento</option>
                <option value="fechado" <?php echo $os['status'] == 'fechado' ? 'selected' : ''; ?>>Fechado</option>
            </select>

            <button type="submit">Atualizar Ordem de Serviço</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
