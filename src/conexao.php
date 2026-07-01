<?php
    // --------------------------------------------
    // CONEXÃO COM O BANCO DE DADOS
    // --------------------------------------------
    // Este arquivo deverá ser utilizado em todos os arquivos que fazem
    // alguma operação no banco de dados.
    // Abre a conexão com o banco de dados MySQL, informando:
    // - o servidor ("mysql"), que é o NOME DO SERVIÇO no Docker
    // - o usuário (root)
    // - a senha (1234)
    // - e o nome do banco (desen_web)

    try {
        $conn = mysqli_connect("mysql", "root", "1234", "desen_web");
    } catch (mysqli_sql_exception $e) {
        die("Erro ao conectar");
    }
?>
