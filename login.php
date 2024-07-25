<?php 
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];

	$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
	$stmt->execute(['usuario' => $usuario]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user && password_verify($senha, $user['senha'])) {
		$_SESSION['user_id'] = $user['id'];
		header('Location: index.php');
		exit;
	} else {
		$error_message = 'Usuário ou senha inválidos';
	}
} 
 ?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Login</title>
 	<link rel="stylesheet" type="text/css" href="css/login.css">
 </head>
 <body>
 	<section class="container" aria-labelledby="form-title">
 		<h1 id="form-title">Login</h1>

 		<?php if (isset($error_message)): ?>
 			<div class="error-message">
 				<?php echo $error_message; ?>
 			</div>
 		<?php endif; ?>
 		
 		<form method="POST" aria-describedby="form-description">
 			<p>Digite suas credenciais para acessar a aplicação.</p>

 			<label for="usuario">Usuário:</label>
 			<input type="text" id="usuario" name="usuario" placeholder="Usuário" required>

 			<label for="senha">Senha:</label>
 			<input type="password" id="senha" name="senha" placeholder="Senha" required>

 			<button type="submit">Login</button>
 		</form>	

 		<div class="register-link">
 			<p>Não tem uma conta? <a href="register.php">Registre-se aqui</a></p>
 		</div>
 	</section>
 </body>
 </html>