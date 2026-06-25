<?php
    $host = "mysql";
    $usuario = "root";
    $senha = "1234";
    $banco = "desen_web";

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
?>