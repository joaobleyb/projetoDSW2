<?php
    require_once("../verificar_login.php");
    require_once("../conexao.php");

    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    $sql = "DELETE FROM filmes WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    try {
        mysqli_stmt_execute($stmt);

        $_SESSION["msg"] = "Filme excluído com sucesso!";
        $_SESSION["cor"] = "green";
    } catch (mysqli_sql_exception $e) {
        $_SESSION["msg"] = "Erro ao excluir filme.";
        $_SESSION["cor"] = "red";
    }

    header("Location: listar.php");
    exit;
?>
