<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $delete_vars);
    $id = $delete_vars['id'];

    $query = "DELETE FROM usuarios WHERE id='$id'";
    
    if ($connection->query($query) === TRUE) {
        echo "Registro excluído com sucesso!";
    } else {
        echo "Erro ao excluir o registro: " . $connection->error;
    }
}

$connection->close();
?>
