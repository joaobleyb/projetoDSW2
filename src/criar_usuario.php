<?php
    require_once "conexao.php";

    $nome = "Joao";
    $email = "joao@email.com";
    $senha = password_hash("123456", PASSWORD_DEFAULT);

    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "Usuário já existe. Pode testar o login.";
        exit;
    }

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        echo "Usuário criado com sucesso!";
    } else {
        echo "Erro ao criar usuário: " . $conn->error;
    }
?>