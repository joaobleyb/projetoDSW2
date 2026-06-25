<?php
require_once "../verificar_login.php";
require_once "../conexao.php";

$resultado = $conn->query("SELECT * FROM generos ORDER BY genero ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gêneros</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-card">
            <h1>Gêneros</h1>

            <a href="criar.php"><button>Novo Gênero</button></a>

            <table>
                <thead>
                    <tr>
                        <th>Gênero</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($genero = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $genero["genero"]; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $genero["id"]; ?>">Editar</a>
                                <a href="deletar.php?id=<?php echo $genero["id"]; ?>" onclick="return confirm('Tem certeza?')">Deletar</a>
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