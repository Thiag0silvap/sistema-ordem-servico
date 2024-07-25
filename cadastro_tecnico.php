<?php 
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$nome = $_POST['nome'];
$especialidade = $_POST['especialidade'];
$telefone = $_POST['telefone'];

try {
$stmt = $pdo->prepare('INSERT INTO tecnicos (nome, especialidade, telefone) VALUES (:nome, :especialidade, :telefone)');
$stmt->execute([':nome' => $nome, ':especialidade' => $especialidade, ':telefone' => $telefone]);

$message = 'Técnico cadastrado com sucesso';

} catch (PDOException $e) {
  $message = 'Erro ao cadastrar técnico: ' . $e->getMessage();
}
}
?>

<!DOCTYPE html>
<html lang="pt-br"> 
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cadastro de Técnico</title>
<link rel="stylesheet" type="text/css" href="css/tecnico.css">
</head>
<body>
<section class="container" aria-labelledby="form-title">
	
<h1>Cadastro de Técnico</h1>

<?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Erro') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

<form method="POST" aria-describedby="form-description">

<p id="form-description">Preencha os campos abaixo para cadastrar um novo técnico.</p>

	<label for="nome">Nome:</label>
<input type="text" id="nome" name="nome" placeholder="Nome" required>

	<label for="especialidade">Especialidade:</label>
<input type="text" id="especialidade" name="especialidade" placeholder="Especialidade" required>

	<label for="telefone">Telefone:</label>
<input type="tel" id="telefone" name="telefone" placeholder="Telefone" required>


<button type="submit">Cadastrar Técnico</button>
</form>	
</section>
</body>
</html>