<?php
// Configurações de conexão com o banco de dados MySQL (XAMPP)
$host = 'localhost';
$dbname = 'portfolio_db';
$usuario = 'root';
$senha = ''; // No XAMPP padrão, o root não tem senha

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $usuario,
        $senha
    );
    // Faz o PDO lançar exceções quando algo der errado (facilita achar erros)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
