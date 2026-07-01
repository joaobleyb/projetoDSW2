<?php
    require_once("../verificar_login.php");
    require_once("../conexao.php");

    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    $sql = "DELETE FROM generos WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    try {
        mysqli_stmt_execute($stmt);

        $_SESSION["msg"] = "Gênero excluído com sucesso!";
        $_SESSION["cor"] = "green";
    } catch (mysqli_sql_exception $e) {
        // erro 1451 = não é possível excluir por existir filme(s) vinculado(s) a este gênero
        $_SESSION["msg"] = "Não foi possível excluir: este gênero está em uso por algum filme.";
        $_SESSION["cor"] = "red";
    }

    header("Location: listar.php");
    exit;
?>
