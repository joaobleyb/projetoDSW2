<?php
    require_once "../verificar_login.php";
    require_once "../conexao.php";

    $erro = "";
    $id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

    $sql = "SELECT * FROM filmes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        header("Location: listar.php");
        exit;
    }

    $filme = $resultado->fetch_assoc();
    $generos = $conn->query("SELECT * FROM generos ORDER BY genero ASC");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo         = trim($_POST["titulo"]);
        $diretor        = trim($_POST["diretor"]);
        $genero_id      = (int) $_POST["genero_id"];
        $duracao        = (int) $_POST["duracao"];
        $ano_lancamento = (int) $_POST["ano_lancamento"];
        $plataforma     = $_POST["plataforma"];

        $plataformas_validas = ["streaming", "cinemas", "ambos"];

        if (empty($titulo) || empty($diretor) || $genero_id === 0 || $duracao === 0 || $ano_lancamento === 0 || !in_array($plataforma, $plataformas_validas)) {
            $erro = "Preencha todos os campos corretamente.";
        } else {
            $sql = "UPDATE filmes SET titulo = ?, diretor = ?, genero_id = ?, duracao = ?, ano_lancamento = ?, plataforma = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiissi", $titulo, $diretor, $genero_id, $duracao, $ano_lancamento, $plataforma, $id);

            if ($stmt->execute()) {
                header("Location: listar.php");
                exit;
            } else {
                $erro = "Erro ao atualizar filme.";
            }
        }
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

            <?php if ($erro): ?>
                <div class="erro"><?php echo $erro; ?></div>
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
                        <?php while ($genero = $generos->fetch_assoc()): ?>
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