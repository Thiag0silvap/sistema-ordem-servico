<?php 
require 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM ordens_de_servico WHERE id = ?');
$stmt->execute([$id]);
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
}

$stmt = $pdo->prepare('UPDATE ordens_de_servico SET cliente_id = ?, tecnico_id = ?, data = ?, descricao = ?, status = ? WHERE id = ?');

$stmt->execute([$cliente_id, $tecnico_id, $data, $descricao, $status, $id]);

echo 'Ordem de serviço atualizada com sucesso';
 ?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Atualizar Ordem de Serviço</title>
 </head>
 <body>
 	<h1>Atualizar Ordem de Serviço</h1>
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
 		<input type="text" name="status" value="<?php echo htmlspecialchars($os['status']); ?>" required>

 		<button type="submit">Atualizar Ordem de Serviço</button>
 	</form>
 </body>
 </html>