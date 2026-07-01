<?php
    require_once("../verificar_login.php");
    require_once("../conexao.php");

    // recupera o id do gênero que vem pela url e converte para inteiro - boa prática
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    $sql = "SELECT * FROM generos WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) !== 1) {
        $_SESSION["msg"] = "Gênero não encontrado.";
        $_SESSION["cor"] = "red";

        header("Location: listar.php");
        exit;
    }

    $genero = mysqli_fetch_array($resultado);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = trim($_POST["genero"]);

        if (empty($nome)) {
            $_SESSION["msg"] = "O campo gênero é obrigatório.";
            $_SESSION["cor"] = "red";
        } else {
            $sql_update = "UPDATE generos SET genero = ? WHERE id = ?";

            $stmt_update = mysqli_prepare($conn, $sql_update);

            mysqli_stmt_bind_param($stmt_update, "si", $nome, $id);

            try {
                mysqli_stmt_execute($stmt_update);

                $_SESSION["msg"] = "Gênero atualizado com sucesso!";
                $_SESSION["cor"] = "green";

                header("Location: listar.php");
                exit;
            } catch (mysqli_sql_exception $e) {
                $_SESSION["msg"] = "Erro ao atualizar gênero.";
                $_SESSION["cor"] = "red";
            }
        }

        // mantém o dado digitado na tela em caso de erro
        $genero["genero"] = $nome;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Gênero</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-card">
            <h1>Editar Gênero</h1>

            <?php if (isset($_SESSION["msg"])): ?>
                <div class="erro" style="<?= $_SESSION["cor"] === "red" ? "" : "background:#f0fff4; color:#2f7a3d; border-color:#c6f0cf;"; ?>">
                    <?= $_SESSION["msg"]; ?>
                </div>
                <?php
                    unset($_SESSION["msg"]);
                    unset($_SESSION["cor"]);
                ?>
            <?php endif; ?>

            <form action="editar.php?id=<?php echo $id; ?>" method="POST">
                <div class="campo">
                    <label for="genero">Gênero</label>
                    <input 
                        type="text" 
                        id="genero" 
                        name="genero" 
                        value="<?php echo htmlspecialchars($genero["genero"]); ?>"
                        required
                    >
                </div>

                <button type="submit">Salvar</button>
            </form>

            <a href="listar.php">Voltar</a>
        </section>
    </main>

</body>
</html>
