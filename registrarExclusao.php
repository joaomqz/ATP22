<?php
session_start();
require 'conexao1.php';

// Verificar se a requisição é do tipo POST e se existe uma sessão de usuário válida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {
    // Receber os dados enviados via POST (formato JSON)
    $data = json_decode(file_get_contents("php://input"));

    // ID do usuário logado
    $idUsuario = $_SESSION['idUser'];

    // Itens a serem excluídos
    $items = $data->item;

    // Preparar as queries SQL para inserir as exclusões e deletar da tabela de compras
    $deleteStmt = $pdo->prepare("DELETE FROM compras WHERE id_usuario = :id_usuario AND item = :item AND valor = :valor");

    try {
        // Iniciar transação
        $pdo->beginTransaction();

        // Iterar sobre os itens e executar a inserção e deleção
        foreach ($items as $item) {
            // Inserir na tabela de exclusões
            $insertStmt->execute(['id_usuario' => $idUsuario, 'item' => $item->name, 'valor' => $item->value]);

            // Deletar da tabela de compras
            $deleteStmt->execute(['id_usuario' => $idUsuario, 'item' => $item->name, 'valor' => $item->value]);
        }

        // Também deletar a moto da tabela de compras
        $deleteMotoStmt = $pdo->prepare("DELETE FROM compras WHERE id_usuario = :id_usuario AND item = 'Moto Harley'");
        $deleteMotoStmt->execute(['id_usuario' => $idUsuario]);

        // Confirmar a transação
        $pdo->commit();

        // Verificar se as operações foram bem-sucedidas
        if ($insertStmt->rowCount() > 0 || $deleteStmt->rowCount() > 0 || $deleteMotoStmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum registro foi modificado']);
        }

    } catch (PDOException $e) {
        // Cancelar a transação em caso de erro
        $pdo->rollback();
        echo json_encode(['success' => false, 'message' => 'Erro ao registrar a exclusão: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
}
?>
