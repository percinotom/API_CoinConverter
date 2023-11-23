<?php
include '../conexao.php';
include '../cors.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->login) && isset($data->senha)) {
        $login = $data->login;
        $senha = $data->senha;

        $query = "SELECT * FROM usuarios WHERE BINARY login = '$login'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($senha, $row['senha'])) {
                $userData = array(
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'login' => $row['login']
                );
                $response = array('success' => true, 'message' => 'Login bem-sucedido', 'user' => $userData);
                echo json_encode($response);
            } else {
                $response = array('success' => false, 'message' => 'Senha incorreta.');
                echo json_encode($response);
            }
        } else {
            $response = array('success' => false, 'message' => 'Usuário não encontrado.');
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'Campos ausentes.');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Método não permitido.');
    echo json_encode($response);
}

$connection->close();
?>