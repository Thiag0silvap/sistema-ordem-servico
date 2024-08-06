<?php 
require 'db.php';

// Verifica se o ID do cliente foi passado pela URL
if (isset($_GET['id'])) {
	$cliente_id = $_GET['id'];

	// Busca os dados do cliente no banco de dados
	$stmt = $pdo->prepare('SELECT * FROM clientes WHERE id = :id');
	$stmt->execute(['id' => $cliente_id]);
	$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

	// Verifica se o cliente foi encontrado
	if (!$cliente) {
		echo 'Cliente não encontrado';
		exit;
	}
} else {
	echo 'ID do cliente não fornecido';
	exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$endereco = $_POST['endereco'];
	$telefone = $_POST['telefone'];

	// Atualiza os dados do cliente no banco de dados
	try {
		$stmt = $pdo->prepare('UPDATE clientes SET nome = :nome, endereco = :endereco, telefone = :telefone WHERE id = :id');
		$stmt->execute([
			'nome' => $nome,
			'endereco' => $endereco,
			'telefone' => $telefone,
			'id' => $cliente_id
		]);

		echo 'Cliente atualizado com sucesso';
	} catch (PDOException $e) {
		echo 'Erro ao atualizar cliente: ' . $e->getMessage();
	}
}
 ?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Atualizar Cliente</title>
 	<link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/cadastro.css">
 </head>
 <body>
 	<header>
 		<h1>Atualizar Cliente</h1>
 	</header>
 	<main>
 		<section class="container"  aria-labelledby="form-title">
 		<h1 id="form-title">Atualizar Cliente</h1>

 		<form method="POST" aria-describedby="form-description">
 			<p id="form-title">Atualize os dados do cliente nos campos abaixo.</p>

 			<label for="nome">Nome:</label>
 			<input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>

 			<label for="endereco">Endereço:</label>
 			<input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($cliente['endereco']); ?>" required>

 			<label for="telefone">Telefone:</label>
 			<input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>" required>
 			<button type="submit">Atualizar Cliente</button>
 		</form>
 	</section>
 	</main>
 	<footer>
 		<p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
 	</footer>
 	 </body>
 </html>