<?php
    require_once "../verificar_login.php";
    require_once "../conexao.php";

    $erro = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $genero = trim($_POST["genero"]);

        if (empty($genero)) {
            $erro = "O campo gênero é obrigatório.";
        } else {
            $sql = "INSERT INTO generos (genero) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $genero);

            if ($stmt->execute()) {
                header("Location: listar.php");
                exit;
            } else {
                $erro = "Erro ao cadastrar gênero.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Gênero</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-card">
            <h1>Novo Gênero</h1>

            <?php if ($erro): ?>
                <div class="erro"><?php echo $erro; ?></div>
            <?php endif; ?>

            <form action="criar.php" method="POST">
                <div class="campo">
                    <label for="genero">Gênero</label>
                    <input 
                        type="text" 
                        id="genero" 
                        name="genero" 
                        placeholder="Ex: Ação, Comédia..."
                        required
                    >
                </div>

                <button type="submit">Cadastrar</button>
            </form>

            <a href="listar.php">Voltar</a>
        </section>
    </main>

</body>
</html>