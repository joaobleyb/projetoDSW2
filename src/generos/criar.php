<?php
    require_once("../verificar_login.php");
    require_once("../conexao.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $genero = trim($_POST["genero"]);

        if (empty($genero)) {
            $_SESSION["msg"] = "O campo gênero é obrigatório.";
            $_SESSION["cor"] = "red";
        } else {
            $sql = "INSERT INTO generos (genero) VALUES (?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "s", $genero);

            try {
                mysqli_stmt_execute($stmt);

                $_SESSION["msg"] = "Gênero cadastrado com sucesso!";
                $_SESSION["cor"] = "green";

                header("Location: listar.php");
                exit;
            } catch (mysqli_sql_exception $e) {
                $_SESSION["msg"] = "Erro ao cadastrar gênero.";
                $_SESSION["cor"] = "red";
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

            <?php if (isset($_SESSION["msg"])): ?>
                <div class="erro" style="<?= $_SESSION["cor"] === "red" ? "" : "background:#f0fff4; color:#2f7a3d; border-color:#c6f0cf;"; ?>">
                    <?= $_SESSION["msg"]; ?>
                </div>
                <?php
                    unset($_SESSION["msg"]);
                    unset($_SESSION["cor"]);
                ?>
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
