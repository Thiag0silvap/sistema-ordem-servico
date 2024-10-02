<?php 
require 'db.php';

// Verifica se o ID da Ordem de serviço foi passado pela URL
if (isset($_GET['id'])) {
    $os_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Verifica se o ID é um número válido
    if (filter_var($os_id, FILTER_VALIDATE_INT)) {
        // Deleta a ordem de serviço do banco de dados
        try {
            $stmt = $pdo->prepare('DELETE FROM ordens_de_servico WHERE id = :id');
            $stmt->execute(['id' => $os_id]);

            // Redireciona para a página de lista de ordens de serviço com mensagem de sucesso
            header('Location: listar_os.php?message=Ordem de serviço excluída com sucesso');
            exit;
        } catch (PDOException $e) {
            echo 'Erro ao excluir ordem de serviço: ' . htmlspecialchars($e->getMessage());
        }
    } else {
        echo 'ID da ordem de serviço inválido';
    }
} else {
    echo 'ID da ordem de serviço não fornecido';
}
?>
