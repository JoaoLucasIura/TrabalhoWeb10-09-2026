<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$dbname = 'livraria';
$user = 'root';
$senha = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão: ' . $e->getMessage()]);
    exit;
}

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        $stmt = $pdo->query("SELECT * FROM livros ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        $sql = "INSERT INTO livros (titulo, autor, editora, ano_publicacao, preco, quantidade)
                VALUES (:titulo, :autor, :editora, :ano, :preco, :quantidade)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $dados['titulo'],
            ':autor' => $dados['autor'],
            ':editora' => $dados['editora'] ?? null,
            ':ano' => $dados['ano_publicacao'] ?? null,
            ':preco' => $dados['preco'],
            ':quantidade' => $dados['quantidade'] ?? 0
        ]);
        echo json_encode(['mensagem' => 'Livro cadastrado com sucesso!', 'id' => $pdo->lastInsertId()]);
        break;

    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'), true);
        $sql = "UPDATE livros SET titulo=:titulo, autor=:autor, editora=:editora,
                ano_publicacao=:ano, preco=:preco, quantidade=:quantidade WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $dados['titulo'],
            ':autor' => $dados['autor'],
            ':editora' => $dados['editora'] ?? null,
            ':ano' => $dados['ano_publicacao'] ?? null,
            ':preco' => $dados['preco'],
            ':quantidade' => $dados['quantidade'] ?? 0,
            ':id' => $dados['id']
        ]);
        echo json_encode(['mensagem' => 'Livro atualizado com sucesso!']);
        break;

    case 'DELETE':
        $dados = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare("DELETE FROM livros WHERE id = :id");
        $stmt->execute([':id' => $dados['id']]);
        echo json_encode(['mensagem' => 'Livro removido com sucesso!']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['erro' => 'Método não permitido']);
        break;
}
