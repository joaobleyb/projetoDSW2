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

    <main class="login-container">
        <section class="login-card">
            <h1>Filmes</h1>

            <a href="criar.php"><button>Novo Filme</button></a>

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

            <a href="../principal.php">Voltar</a>
        </section>
    </main>

</body>
</html>