<?php
require 'db.php';

// Verifica se o ID do técnico foi passado pela URL
if (isset($_GET['id'])) {
	$tecnico_id = $_GET['id'];

	// Busca os dados do técnico no banco de dados
	$stmt = $pdo->prepare('SELECT * FROM tecnicos WHERE id = :id');
	$stmt->execute(['id' => $tecnico_id]);
	$tecnico = $stmt->fetch(PDO::FETCH_ASSOC);

	// Verifica se o técnico foi encontrado
	if (!$tecnico) {
		echo 'Técnico não encontrado';
		exit;
	}
} else {
	echo 'ID do técnico não fornecido';
	exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$especialidade = $_POST['especialidade'];
	$telefone = $_POST['telefone'];

	// Atualiza os dados do técnico no banco de dados
	try {
		$stmt = $pdo->prepare('UPDATE tecnicos SET nome = :nome, especialidade = :especialidade, telefone = :telefone WHERE id = :id');
		$stmt->execute([
			'nome' => $nome,
			'especialidade' => $especialidade,
			'telefone' => $telefone,
			'id' => $tecnico_id
		]);

		echo 'Técnico atualizado com sucesso';
	} catch (PDOException $e) {
		echo 'Erro ao atualizar técnico: ' . $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Atualizar Técnico</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
<header>
	<h1>Atualizar Técnico</h1>
</header>
<main>
	<section class="container" aria-labelledby="form-title">
		<h1 id="form-title">Atualizar Técnico</h1>

		<form method="POST" aria-describedby="form-description">
			<p id="form-description">Atualize os dados do técnico nos campos abaixo.</p>

			<label for="nome">Nome:</label>
			<input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($tecnico['nome']); ?>" required>

			<label for="especialidade">Especialidade:</label>
			<input type="text" id="especialidade" name="especialidade" value="<?php echo htmlspecialchars($tecnico['especialidade']); ?>" required>

			<label for="telefone">Telefone:</label>
			<input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($tecnico['telefone']); ?>" required>

			<button type="submit">Atualizar Técnico</button>
		</form>
	</section>
</main>
<footer>
	<p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
</footer>
</body>
</html>
