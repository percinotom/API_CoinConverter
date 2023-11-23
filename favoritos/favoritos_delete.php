<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['favorito_id']) && isset($data['user_id'])) {
        $favorito_id = $connection->real_escape_string($data['favorito_id']);
        $user_id = $connection->real_escape_string($data['user_id']);

        $query = "DELETE FROM favoritos WHERE id = '$favorito_id' AND usuario_id = '$user_id'";
        
        if ($connection->query($query)) {
            http_response_code(200);
            echo json_encode(['message' => 'Favorito excluído com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao excluir o favorito: ' . $connection->error]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID do favorito ou ID do usuário ausentes ou inválidos']);
    }
}

$connection->close();
?>
