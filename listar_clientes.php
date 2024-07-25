<?php 
require 'db.php';

$clientes = $pdo->query('SELECT * FROM clientes')->fetchAll(PDO::FETCH_ASSOC);
 ?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Lista de Clientes</title>
 	<link rel="stylesheet" type="text/css" href="css/listar_clientes.css">
 </head>
 <body>
 	<header>
 		<h1>Lista de Clientes</h1>
 	</header>
 	<main>
 		<table>
 			<thead>
 				<tr>
 					<th>ID</th>
 					<th>Nome</th>
 					<th>Endereço</th>
 					<th>Telefone</th>
 					<th>Ações</th>
 				</tr>
 			</thead>
 			<tbody>
 				<?php foreach ($clientes as $cliente): ?>
 				<tr>
 					<td><?php echo htmlspecialchars($cliente['id']); ?></td>
 					<td><?php echo htmlspecialchars($cliente['nome']); ?></td>
 					<td><?php echo htmlspecialchars($cliente['endereco']); ?></td>
 					<td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
 					<td>
 						<a href="atualizar_cliente.php?id=<?php echo htmlspecialchars($cliente['id']); ?>">Editar</a>

 						<a href="excluir_cliente.php?id=<?php echo htmlspecialchars($cliente['id']); ?>" onclick="return confirm('Tem certeza que deseja excluir este cliente?');">Excluir</a>
 					</td>
 				</tr>
 			<?php endforeach; ?>
 			</tbody>
 		</table>
 	</main>
 </body>
 </html>