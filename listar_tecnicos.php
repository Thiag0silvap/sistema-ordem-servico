<?php 
require 'db.php';

$tecnicos = $pdo->query('SELECT * FROM tecnicos')->fetchAll(PDO::FETCH_ASSOC);
 ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lista de Técnicos</title>
	<link rel="stylesheet" type="text/css" href="css/listar_tecnicos.css">
</head>
<body>
	<header>
		<h1>Lista de Técnicos</h1>
	</header>
	<main>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Nome</th>
					<th>Especialidade</th>
					<th>Telefone</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($tecnicos as $tecnico): ?>
				<tr>
					<td><?php echo htmlspecialchars($tecnico['id']); ?></td>
					<td><?php echo htmlspecialchars($tecnico['nome']); ?></td>
					<td><?php echo htmlspecialchars($tecnico['especialidade']); ?></td>
					<td><?php echo htmlspecialchars($tecnico['telefone']); ?></td>
					<td>
						<a href="atualizar_tecnico.php?id=<?php echo htmlspecialchars($tecnico['id']); ?>">Editar</a>

						<a href="excluir_tecnico.php?id=<?php echo htmlspecialchars($tecnico['id']); ?>" onclick="return confirm('Tem certeza que deseja excluir este técnico?');">Excluir</a>
					</td>
				</tr>
				<?php endforeach; ?>	
			</tbody>
		</table>
	</main>
</body>
</html>