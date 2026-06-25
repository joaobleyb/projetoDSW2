<?php
    session_start();

    if (isset($_SESSION["usuario_id"])) {
        header("Location: principal.php");
        exit;
    }

    $erro = isset($_GET["erro"]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Filmes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-card">
            <h1>Login</h1>
            <p>Entre para acessar o sistema</p>

            <?php if ($erro): ?>
                <div class="erro">
                    Email ou senha inválidos.
                </div>
            <?php endif; ?>

            <form action="autenticar.php" method="POST">
                <div class="campo">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Digite seu email"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="senha">Senha</label>
                    <input 
                        type="password" 
                        id="senha" 
                        name="senha" 
                        placeholder="Digite sua senha"
                        required
                    >
                </div>

                <button type="submit">Entrar</button>
            </form>
        </section>
    </main>

</body>
</html>