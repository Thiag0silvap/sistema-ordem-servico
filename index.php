<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/styles.css">
<title>Home</title>
</head>
<body>
<header>
	<h1>Sistema de Ordem de Serviço</h1>	
</header>
	<nav>
		<ul>
		<li><a href="cadastro_cliente.php">Cadastrar Cliente</a></li>
		<li><a href="cadastro_tecnico.php">Cadastrar Técnico</a></li>
		<li><a href="Cadastro_os.php">Cadastrar Ordem de Serviço</a></li>
		<li><a href="listar_clientes.php">Listar Clientes</a></li>
		<li><a href="listar_tecnicos.php">Listar Técnicos</a></li>
		<li><a href="listar_os.php">Listar Ordens de Serviço</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
	</nav>
	<main>
		<section>
			<h2>Bem-vindo ao Sistema de Ordem de Serviço</h2>
			<p>Aqui você pode gerenciar suas ordens de serviço de maneira eficiente.</p>
		</section>
	</main>
	<footer>
		<p>&copy; 2024 Sistema de Ordem de Serviço. Todos os direitos reservados.</p>
	</footer>
</body>
</html>


