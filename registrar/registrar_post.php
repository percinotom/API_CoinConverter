<?php
include '../conexao.php';
include '../cors.php';

$response = array('success' => false, 'message' => 'Erro desconhecido ao registrar.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->nome) && isset($data->login) && isset($data->senha)) {
        $nome = $data->nome;
        $login = $data->login;
        $senha = password_hash($data->senha, PASSWORD_DEFAULT);

        $verificarLogin = "SELECT * FROM usuarios WHERE login = '$login'";
        $result = $connection->query($verificarLogin);

        if ($result->num_rows > 0) {
            $response['message'] = 'Login já está em uso. Escolha outro.';
        } else {
            $query = "INSERT INTO usuarios (nome, login, senha) VALUES ('$nome', '$login', '$senha')";

            if ($connection->query($query) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Registro bem-sucedido!';
            } else {
                $response['message'] = 'Erro ao registrar: ' . $connection->error;
                error_log('Erro na consulta SQL: ' . $query . ' - Erro: ' . $connection->error);
            }
        }
    } else {
        $response['message'] = 'Campos ausentes.';
    }
} else {
    $response['message'] = 'Método não permitido.';
}

$connection->close();

echo json_encode($response);
?>
