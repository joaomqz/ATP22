<?php
session_start();
require 'conexao1.php';

if (isset($_POST['nome']) && !empty($_POST['nome']) && 
    isset($_POST['email']) && !empty($_POST['email']) && 
    isset($_POST['senha']) && !empty($_POST['senha'])) {

    $nome = addslashes($_POST['nome']);
    $email = addslashes($_POST['email']);
    $senha = md5(addslashes($_POST['senha']));

    try {
        global $pdo;
        $sql = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['idUser'] = $pdo->lastInsertId();
            header("Location: customizacao.php");
        } else {
            header("Location: criarCadastro.php");
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: criarCadastro.php");
}
?>
