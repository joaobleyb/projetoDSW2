<?php
    require_once("../verificar_login.php");
    require_once("../conexao.php");

    // consulta usada para popular o select de gêneros
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
            // consulta a ser utilizada
            $sql = "INSERT INTO filmes (titulo, diretor, genero_id, duracao, ano_lancamento, plataforma) VALUES (?, ?, ?, ?, ?, ?)";

            // inicia a consulta SQL antes da execução
            $stmt = mysqli_prepare($conn, $sql);

            // define os parâmetros da consulta (?)
            // s - string / i - integer
            mysqli_stmt_bind_param($stmt, "ssiiis", $titulo, $diretor, $genero_id, $duracao, $ano_lancamento, $plataforma);

            // executa a consulta sql com os valores que foram adicionados à query
            try {
                mysqli_stmt_execute($stmt);

                $_SESSION["msg"] = "Filme cadastrado com sucesso!";
                $_SESSION["cor"] = "green";

                header("Location: listar.php");
                exit;
            } catch (mysqli_sql_exception $e) {
                $_SESSION["msg"] = "Erro ao cadastrar filme.";
                $_SESSION["cor"] = "red";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Filme</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-card">
            <h1>Novo Filme</h1>

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
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ex: Inception" required>
                </div>

                <div class="campo">
                    <label for="diretor">Diretor</label>
                    <input type="text" id="diretor" name="diretor" placeholder="Ex: Christopher Nolan" required>
                </div>

                <div class="campo">
                    <label for="genero_id">Gênero</label>
                    <select id="genero_id" name="genero_id" required>
                        <option value="">Selecione um gênero</option>
                        <?php while ($genero = mysqli_fetch_array($generos)): ?>
                            <option value="<?php echo $genero["id"]; ?>">
                                <?php echo htmlspecialchars($genero["genero"]); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="duracao">Duração (minutos)</label>
                    <input type="number" id="duracao" name="duracao" min="1" placeholder="Ex: 148" required>
                </div>

                <div class="campo">
                    <label for="ano_lancamento">Ano de Lançamento</label>
                    <input type="number" id="ano_lancamento" name="ano_lancamento" min="1888" max="2100" placeholder="Ex: 2010" required>
                </div>

                <div class="campo">
                    <label>Plataforma</label>
                    <label><input type="radio" name="plataforma" value="streaming" required> Streaming</label>
                    <label><input type="radio" name="plataforma" value="cinemas"> Cinemas</label>
                    <label><input type="radio" name="plataforma" value="ambos"> Ambos</label>
                </div>

                <button type="submit">Cadastrar</button>
            </form>

            <a href="listar.php">Voltar</a>
        </section>
    </main>

</body>
</html>
