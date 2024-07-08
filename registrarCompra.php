<?php
session_start();
require 'conexao1.php';

if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {
   
    $data = json_decode(file_get_contents("php://input"));

    $idUsuario = $_SESSION['idUser'];
    $moto = $data->moto;
    $items = $data->items;

   
    $stmt = $pdo->prepare("INSERT INTO compras (id_usuario, item, valor) VALUES (:id_usuario, :item, :valor)");

    o
    foreach ($items as $item) {
        $stmt->execute(['id_usuario' => $idUsuario, 'item' => $item->name, 'valor' => $item->value]);
    }


    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Falha ao registrar a compra']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
}

?>
