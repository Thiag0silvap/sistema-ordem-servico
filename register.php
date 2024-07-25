<?php 
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario = $_POST['usuario'];
	$senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

	try {
		$stmt = $pdo->prepare('INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)');
		$stmt->execute([':usuario' => $usuario, ':senha' => $senha]);
		$message = 'Usuário registrado com sucesso. <a href="login.php">Faça login aqui</a>';
	} catch (PDOException $e) {
		$message = 'Erro ao registrar usuário: ' . $e->getMessage();
	}
} 
 ?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Cadastro de Usuário</title>
 	<link rel="stylesheet" type="text/css" href="css/register.css">
 </head>
 <body>
 	<section class="container" aria-labelledby="form-title">
 		<h1 id="form-title">Registro</h1>
 		<?php if ($message): ?>
 			<div class="message <?php echo isset($stmt) && $stmt ? 'success' : 'error'; ?>">
 				<?php echo $message; ?>
 			</div>
 		<?php endif; ?>
 		<form method="POST" aria-describedby="form-description">
 			<p id="form-description">Preencha os campos abaixo para criar uma nova conta.</p>

 			<label for="usuario">Usuário:</label>
 			<input type="text" id="usuario" name="usuario" placeholder="Usuário" required>

 			<label for="senha">Senha:</label>
 			<input type="password" id="senha" name="senha" placeholder="Senha" required>

 			<button type="submit">Registrar</button>
 		</form>

 		<div>
 			<p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
 		</div>
 	</section>
 </body>
 </html>