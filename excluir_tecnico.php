<?php 
require 'db.php';

// Verifica se o ID do técnico foi passado pela URL
if (isset($_GET['id'])) {
	$tecnico_id = $_GET['id'];

	// Deleta o técnico do banco de dados
	try {
		$stmt = $pdo->prepare('DELETE FROM tecnicos WHERE id = :id');
		$stmt->execute(['id' => $tecnico_id]);

		// Redireciona para a página de lista de técnicos com mensagem de sucesso
		header('Location: listar_tecnicos.php?message=Técnico excluído com sucesso');
		exit;
	} catch (PDOException $e) {
		echo 'Erro ao excluir técnico: ' . $e->getMessage();
	}
} else {
	echo 'ID do técnico não fornecido';
}

 ?>