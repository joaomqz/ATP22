<?php
session_start();
require 'conexao1.php';

if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {

    $data = json_decode(file_get_contents("php://input"));

    if ($data) {
        $idUsuario = $_SESSION['idUser'];
        $items = $data->items;

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO compras (id_usuario, item, valor) VALUES (:id_usuario, :item, :valor)");

            foreach ($items as $item) {
                $stmt->execute([
                    'id_usuario' => $idUsuario,
                    'item' => $item->name,
                    'valor' => $item->value
                ]);
            }

            $pdo->commit();

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Falha ao registrar a compra: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
}
?>

