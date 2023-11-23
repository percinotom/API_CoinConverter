<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id) && isset($data->nome) && isset($data->login) && isset($data->senha)) {
        $id = $data->id;
        $nome = $data->nome;
        $login = $data->login;
        $senha = password_hash($data->senha, PASSWORD_DEFAULT);

        $verificarLogin = "SELECT * FROM usuarios WHERE login = '$login' AND id != '$id'";
        $result = $connection->query($verificarLogin);

        if ($result->num_rows > 0) {
            $existingUser = $result->fetch_assoc();

            if ($existingUser['id'] != $id) {
                http_response_code(400);
                echo json_encode(array("message" => "O novo login já está em uso por outro usuário. Escolha outro."));
            } else {
                $query = "UPDATE usuarios SET nome='$nome', login='$login', senha='$senha' WHERE id='$id'";

                if ($connection->query($query) === TRUE) {
                    http_response_code(200);
                    echo json_encode(array("success" => true, "message" => "Registro atualizado com sucesso"));
                } else {
                    http_response_code(500);
                    echo json_encode(array("success" => false, "message" => "Erro ao atualizar o registro: " . $connection->error));
                }
            }
        } else {
            $query = "UPDATE usuarios SET nome='$nome', login='$login', senha='$senha' WHERE id='$id'";

            if ($connection->query($query) === TRUE) {
                http_response_code(200);
                echo json_encode(array("success" => true, "message" => "Registro atualizado com sucesso"));
            } else {
                http_response_code(500);
                echo json_encode(array("success" => false, "message" => "Erro ao atualizar o registro: " . $connection->error));
            }
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Erro: Dados inválidos ou ausentes"));
    }
}

$connection->close();