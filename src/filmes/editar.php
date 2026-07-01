<?php
    require_once("../verificar_login.php");
    require_once("../conexao.php");

    // recupera o id do filme que vem pela url e converte para inteiro - boa prática
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    // consulta a ser utilizada
    $sql = "SELECT * FROM filmes WHERE id = ?";

    // inicia a consulta SQL antes da execução
    $stmt = mysqli_prepare($conn, $sql);

    // define o parâmetro da consulta (?)
    mysqli_stmt_bind_param($stmt, "i", $id);

    // executa a consulta
    mysqli_stmt_execute($stmt);

    // recupera o resultado produzido pela execução da prepared statement
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) !== 1) {
        $_SESSION["msg"] = "Filme não encontrado.";
        $_SESSION["cor"] = "red";

        header("Location: listar.php");
        exit;
    }

    $filme = mysqli_fetch_array($resultado);

    $sql_generos = "SELECT * FROM generos ORDER BY genero ASC";
    $generos = mysqli_query($conn, $sql_generos);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo         = trim($_POST["titulo"]);
        $diretor        = trim($_POST["diretor"]);
        $genero_id      = filter_var($_POST["genero_id"], FILTER_VALIDATE_INT);
        $duracao        = filter_var($_POST["duracao"], FILTER_VALIDATE_INT);
        $ano_lancamento = filter_var($_POST["ano_lancamento"], FILTER_VALIDATE_INT);
        $plataforma     = $_POST["plataforma"];

        $plataformas_validas = ["streaming", "cinemas", "ambos"];

        if (empty($titulo) || empty($diretor) || !$genero_id || !$duracao || !$ano_lancamento || !in_array($plataforma, $plataformas_validas)) {
            $_SESSION["msg"] = "Preencha todos os campos corretamente.";
            $_SESSION["cor"] = "red";
        } else {
            $sql_update = "UPDATE filmes SET titulo = ?, diretor = ?, genero_id = ?, duracao = ?, ano_lancamento = ?, plataforma = ? WHERE id = ?";

            $stmt_update = mysqli_prepare($conn, $sql_update);

            mysqli_stmt_bind_param($stmt_update, "ssiiisi", $titulo, $diretor, $genero_id, $duracao, $ano_lancamento, $plataforma, $id);

            try {
                mysqli_stmt_execute($stmt_update);

                $_SESSION["msg"] = "Filme atualizado com sucesso!";
                $_SESSION["cor"] = "green";

                header("Location: listar.php");
                exit;
            } catch (mysqli_sql_exception $e) {
                $_SESSION["msg"] = "Erro ao atualizar filme.";
                $_SESSION["cor"] = "red";
            }
        }

        // mantém os dados digitados na tela em caso de erro
        $filme["titulo"]         = $titulo;
        $filme["diretor"]        = $diretor;
        $filme["genero_id"]      = $genero_id;
        $filme["duracao"]        = $duracao;
        $filme["ano_lancamento"] = $ano_lancamento;
        $filme["plataforma"]     = $plataforma;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Filme</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-card">
            <h1>Editar Filme</h1>

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
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($filme["titulo"]); ?>" required>
                </div>

                <div class="campo">
                    <label for="diretor">Diretor</label>
                    <input type="text" id="diretor" name="diretor" value="<?php echo htmlspecialchars($filme["diretor"]); ?>" required>
                </div>

                <div class="campo">
                    <label for="genero_id">Gênero</label>
                    <select id="genero_id" name="genero_id" required>
                        <option value="">Selecione um gênero</option>
                        <?php while ($genero = mysqli_fetch_array($generos)): ?>
                            <option value="<?php echo $genero["id"]; ?>" <?php echo $genero["id"] == $filme["genero_id"] ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($genero["genero"]); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="duracao">Duração (minutos)</label>
                    <input type="number" id="duracao" name="duracao" min="1" value="<?php echo $filme["duracao"]; ?>" required>
                </div>

                <div class="campo">
                    <label for="ano_lancamento">Ano de Lançamento</label>
                    <input type="number" id="ano_lancamento" name="ano_lancamento" min="1888" max="2100" value="<?php echo $filme["ano_lancamento"]; ?>" required>
                </div>

                <div class="campo">
                    <label>Plataforma</label>
                    <label><input type="radio" name="plataforma" value="streaming" <?php echo $filme["plataforma"] === "streaming" ? "checked" : ""; ?>> Streaming</label>
                    <label><input type="radio" name="plataforma" value="cinemas" <?php echo $filme["plataforma"] === "cinemas" ? "checked" : ""; ?>> Cinemas</label>
                    <label><input type="radio" name="plataforma" value="ambos" <?php echo $filme["plataforma"] === "ambos" ? "checked" : ""; ?>> Ambos</label>
                </div>

                <button type="submit">Salvar</button>
            </form>

            <a href="listar.php">Voltar</a>
        </section>
    </main>

</body>
</html>
