<?php
    session_start();
    require_once("conexao.php");

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // consulta a ser utilizada
    $sql = "SELECT * FROM usuarios WHERE email = ?";

    // inicia a consulta SQL antes da execução
    $stmt = mysqli_prepare($conn, $sql);

    // define o parâmetro da consulta (?)
    // s - string
    mysqli_stmt_bind_param($stmt, "s", $email);

    // executa a consulta sql com o valor que foi adicionado à query
    mysqli_stmt_execute($stmt);

    // recupera o resultado produzido pela execução da prepared statement
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) === 1) {

        // encontrou um usuário com esse e-mail
        $usuario = mysqli_fetch_array($resultado);

        if (password_verify($senha, $usuario["senha"])) {
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];

            header("Location: principal.php");
            exit;
        }
    }

    // se chegou até aqui, e-mail ou senha estão incorretos
    $_SESSION["msg"] = "Email ou senha inválidos.";
    $_SESSION["cor"] = "red";

    header("Location: login.php");
    exit;
?>
