<?php 
require 'db.php';

// Verifica se o ID do Técnico foi passado pela URL
if (isset($_GET['id'])) {
    $tecnico_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Verifica se o ID é um número válido
    if (filter_var($tecnico_id, FILTER_VALIDATE_INT)) {
        // Deleta o Técnico do banco de dados
        try {
            $stmt = $pdo->prepare('DELETE FROM tecnicos WHERE id = :id');
            $stmt->execute(['id' => $tecnico_id]);

            // Verifica se alguma linha foi afetada
            if ($stmt->rowCount() > 0) {
                // Redireciona para a página de lista de técnicos com mensagem de sucesso
                header('Location: listar_tecnicos.php?message=Técnico excluído com sucesso');
                exit;
            } else {
                // Se nenhuma linha foi afetada, o ID pode não existir
                header('Location: listar_tecnicos.php?message=Técnico não encontrado');
                exit;
            }
        } catch (PDOException $e) {
            echo 'Erro ao excluir técnico: ' . htmlspecialchars($e->getMessage());
        }
    } else {
        echo 'ID do técnico inválido';
    }
} else {
    echo 'ID do técnico não fornecido';
}
?>
