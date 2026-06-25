<?php
    require_once "../verificar_login.php";
    require_once "../conexao.php";

    $erro = "";

    $generos = $conn->query("SELECT * FROM generos ORDER BY genero ASC");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo        = trim($_POST["titulo"]);
        $diretor       = trim($_POST["diretor"]);
        $genero_id     = (int) $_POST["genero_id"];
        $duracao       = (int) $_POST["duracao"];
        $ano_lancamento = (int) $_POST["ano_lancamento"];
        $plataforma    = $_POST["plataforma"];

        $plataformas_validas = ["streaming", "cinemas", "ambos"];

        if (empty($titulo) || empty($diretor) || $genero_id === 0 || $duracao === 0 || $ano_lancamento === 0 || !in_array($plataforma, $plataformas_validas)) {
            $erro = "Preencha todos os campos corretamente.";
        } else {
            $sql = "INSERT INTO filmes (titulo, diretor, genero_id, duracao, ano_lancamento, plataforma) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiiss", $titulo, $diretor, $genero_id, $duracao, $ano_lancamento, $plataforma);

            if ($stmt->execute()) {
                header("Location: listar.php");
                exit;
            } else {
                $erro = "Erro ao cadastrar filme.";
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

            <?php if ($erro): ?>
                <div class="erro"><?php echo $erro; ?></div>
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
                        <?php while ($genero = $generos->fetch_assoc()): ?>
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