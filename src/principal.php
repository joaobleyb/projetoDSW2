<?php require_once "verificar_login.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="principal-container">
    <div class="topbar">
        <span class="topbar-title">Sistema de Filmes</span>
        <span class="topbar-user">
            <div class="avatar">
                <?php echo strtoupper(substr($_SESSION["usuario_nome"], 0, 2)); ?>
            </div>
            <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>
        </span>
    </div>

    <div class="card-grid">
        <a href="filmes/listar.php" class="nav-card">
            <div class="nav-card-icon" style="background:#eef2ff;">🎬</div>
            <h2>Filmes</h2>
            <p>Gerenciar catálogo de filmes</p>
        </a>
        <a href="generos/listar.php" class="nav-card">
            <div class="nav-card-icon" style="background:#f0fdf4;">🏷️</div>
            <h2>Gêneros</h2>
            <p>Gerenciar gêneros de filmes</p>
        </a>
    </div>

    <a href="logout.php">
        <button class="logout-btn">Sair</button>
    </a>
</main>

</body>
</html>