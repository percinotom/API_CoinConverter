<?php
include '../conexao.php';
include '../cors.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM usuarios";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $rows = array();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        echo json_encode($rows);
    } else {
        echo "Nenhum registro encontrado.";
    }
}

$connection->close();
?>
