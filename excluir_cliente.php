<?php 
require 'db.php';

// Verifica se o ID do cliente foi passado pela URL
if (isset($_GET['id'])) {
	$cliente_id = $_GET['id'];

	// Deleta o cliente do banco de dados
	try {
		$stmt = $pdo->prepare('DELETE FROM clientes WHERE id = :id');
		$stmt->execute(['id' => $cliente_id]);

		// Redireciona para a página de lista de clientes com mensagem de sucesso
		header('Location: listar_clientes.php?message=Cliente excluído com sucesso');
		exit;
	} catch (PDOException $e) {
		echo 'Erro ao excluir cliente: ' . $e->getMessage();
	}
} else {
	echo 'ID do cliente não fornecido';
}

 ?>