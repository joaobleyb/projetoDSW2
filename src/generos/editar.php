<?php
require_once "../verificar_login.php";
require_once "../conexao.php";

$erro = "";

// Busca o gênero pelo ID
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

$sql = "SELECT * FROM generos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: listar.php");
    exit;
}

$genero = $resultado->fetch_assoc();

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["genero"]);

    if (empty($nome)) {
        $erro = "O campo gênero é obrigatório.";
    } else {
        $sql = "UPDATE generos SET genero = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nome, $id);

        if ($stmt->execute()) {
            header("Location: listar.php");
            exit;
        } else {
            $erro = "Erro ao atualizar gênero.";
        }
    }
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

            <?php if ($erro): ?>
                <div class="erro"><?php echo $erro; ?></div>
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