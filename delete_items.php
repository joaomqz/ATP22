<?php
require 'verifica.php';

if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])):
    $idUser = $_SESSION['idUser'];

    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'atp2');

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Consulta para deletar os pedidos do usuário
    $sql = "DELETE FROM compras WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idUser);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Pedidos excluídos com sucesso."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Nenhum pedido encontrado para exclusão."]);
    }

    $stmt->close();
    $conn->close();
else:
    echo json_encode(["status" => "error", "message" => "Usuário não autenticado."]);
endif;
?>