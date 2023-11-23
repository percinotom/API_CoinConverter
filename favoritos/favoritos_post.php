<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true);

    if ($dados && isset($dados['favorito']) && isset($dados['usuario_id'])) {
        $usuario_id = $connection->real_escape_string($dados['usuario_id']);
        $expressao = $connection->real_escape_string($dados['favorito']);
        $data = date('Y-m-d');

        $query = $connection->prepare("INSERT INTO favoritos (usuario_id, expressao, data) VALUES (?, ?, ?)");
        $query->bind_param("sss", $usuario_id, $expressao, $data);

        if ($query->execute()) {
            http_response_code(200);
            echo json_encode(['message' => 'Favorito adicionado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao adicionar favorito: ' . $query->error]);
        }

        $query->close();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Dados de favorito ou usuario_id ausentes ou inválidos']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
}

$connection->close();
?>