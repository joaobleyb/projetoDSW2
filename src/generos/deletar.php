<?php
    require_once "../verificar_login.php";
    require_once "../conexao.php";

    $id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

    $sql = "DELETE FROM generos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: listar.php");
    exit;
?>