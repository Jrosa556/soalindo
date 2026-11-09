<?php
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    $stmt = $pdo->prepare("INSERT INTO mensagens (nome, email, mensagem) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $mensagem]);
    header("Location: ../contato.php");
    exit;
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM mensagens WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../contato.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'editar') {
    $id = $_POST['id'];
    $mensagem = $_POST['mensagem'];

    $stmt = $pdo->prepare("UPDATE mensagens SET mensagem = ? WHERE id = ?");
    $stmt->execute([$mensagem, $id]);
    header("Location: ../contato.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM mensagens ORDER BY data_envio DESC");
$mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato e Mensagens</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../sobre.php">Sobre Mim</a></li>
                <li><a href="../contato.php">Contato</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h1>Envie uma Mensagem</h1>
        <form action="../contato.php" method="POST">
            <input type="hidden" name="acao" value="cadastrar">
            <input type="text" name="nome" placeholder="Seu Nome" required>
            <input type="email" name="email" placeholder="Seu E-mail" required>
            <textarea name="mensagem" placeholder="Sua Mensagem" required></textarea>
            <button type="submit">Enviar</button>
        </form>

        <h2>Mensagens Recebidas (CRUD)</h2>
        <?php foreach ($mensagens as $msg): ?>
            <div class="card-mensagem">
                <p><strong><?= htmlspecialchars($msg['nome']) ?></strong> (<?= htmlspecialchars($msg['email']) ?>)</p>
                <p><?= htmlspecialchars($msg['mensagem']) ?></p>

                <form action="../contato.php" method="POST" style="display:inline;">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                    <input type="text" name="mensagem" placeholder="Nova mensagem" required>
                    <button type="submit">Editar</button>
                </form>

                <a href="../contato.php?excluir=<?= $msg['id'] ?>" onclick="return confirm('Excluir mensagem?')">Excluir</a>
            </div>
        <?php endforeach; ?>
    </main>

    <script src="../assets/js/script.js"></script>
</body>
</html>
