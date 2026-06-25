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

    <main class="principal-container">
        <div class="topbar">
            <span class="topbar-title">Gêneros</span>
            <a href="criar.php"><button style="width:auto; padding: 9px 18px; margin:0;">+ Novo Gênero</button></a>
        </div>

        <div style="background:#fff; border:1px solid #ebebeb; border-radius:12px; padding: 8px 0;">
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
                            <td><?php echo htmlspecialchars($genero["genero"]); ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $genero["id"]; ?>">Editar</a>
                                <a href="deletar.php?id=<?php echo $genero["id"]; ?>" onclick="return confirm('Tem certeza?')">Deletar</a>
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