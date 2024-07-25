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
 	 <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
 </head>
 <body>
 	<section class="container"  aria-labelledby="form-title">
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
 </body>
 </html>