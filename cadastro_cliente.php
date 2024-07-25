<?php    
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];

try {
  $stmt = $pdo->prepare('INSERT INTO clientes (nome,endereco, telefone) VALUES (:nome, :endereco, :telefone)');
  $stmt->execute([
   ':nome' => $nome,
   ':endereco' => $endereco, 
   ':telefone' => $telefone
]);
  $message = 'Cliente registrado com sucesso.';
} catch (PDOException $e) {
    $message = 'Erro ao registrar cliente: ' . $e->getMessage();
}

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" type="text/css" href="css/cliente.css">
</head>
<body>
    <section class="container" aria-labelledby="form-title">
        <h1 id="form-title">Cadastro de Cliente</h1>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Erro') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" aria-describedby="form-description">
            <p id="form-description">Preencha os campos abaixo para cadastrar um novo cliente.</p>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Nome completo" required aria-required="true">

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" placeholder="Endereço completo" required aria-required="true">

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" placeholder="Número de telefone" required aria-required="true">

            <button type="submit">Cadastrar Cliente</button>
        </form>
    </section>
</body>
</html>
