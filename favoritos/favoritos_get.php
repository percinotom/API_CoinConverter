<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['user_id'])) {
        $user_id = $connection->real_escape_string($_GET['user_id']);

        $query = "SELECT id, expressao, data FROM favoritos WHERE usuario_id = '$user_id'";

        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $favoritosArray = array();
        
            while ($row = $result->fetch_assoc()) {
                $favorito = array(
                    'id' => $row['id'], // Inclua o campo ID
                    'expressao' => $row['expressao'],
                    'data' => $row['data'],
                );
                $favoritosArray[] = $favorito;
            }
        
            echo json_encode($favoritosArray);
        } else {
            echo json_encode([]);
        }
    } else {
        echo json_encode(['error' => 'ID do usuário não fornecido']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
}

$connection->close();
?>
