<?php
    require_once "../verificar_login.php";
    require_once "../conexao.php";

    $sql = "SELECT filmes.*, generos.genero 
            FROM filmes 
            JOIN generos ON filmes.genero_id = generos.id
            ORDER BY filmes.titulo ASC";

    $resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Filmes</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="principal-container">
        <div class="topbar">
            <span class="topbar-title">Filmes</span>
            <a href="criar.php"><button style="width:auto; padding: 9px 18px; margin:0;">+ Novo Filme</button></a>
        </div>

        <div style="background:#fff; border:1px solid #ebebeb; border-radius:12px; padding: 8px 0;">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Diretor</th>
                        <th>Gênero</th>
                        <th>Duração</th>
                        <th>Ano</th>
                        <th>Plataforma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($filme = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($filme["titulo"]); ?></td>
                            <td><?php echo htmlspecialchars($filme["diretor"]); ?></td>
                            <td><?php echo htmlspecialchars($filme["genero"]); ?></td>
                            <td><?php echo $filme["duracao"]; ?> min</td>
                            <td><?php echo $filme["ano_lancamento"]; ?></td>
                            <td><?php echo ucfirst($filme["plataforma"]); ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $filme["id"]; ?>">Editar</a>
                                <a href="deletar.php?id=<?php echo $filme["id"]; ?>" onclick="return confirm('Tem certeza?')">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="../principal.php" style="display:inline-block; margin-top:16px; font-size:13px; color:#888; text-decoration:none;">← Voltar</a>
    </main>

</body>
</html>