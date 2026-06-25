<?php
    require_once "verificar_login.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-card">
            <h1>Bem-vindo!</h1>

            <p>Olá, <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>.</p>

            <a href="filmes/listar.php"><button>Gerenciar Filmes</button></a>
            <a href="generos/listar.php"><button>Gerenciar Gêneros</button></a>
            <a href="logout.php"><button>Sair</button></a>
        </section>
    </main>

</body>
</html>