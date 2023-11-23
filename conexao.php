<?php
$hostname = 'coinconverter.mysql.dbaas.com.br';
$username = 'coinconverter';
$password = 'Mvlp12@';
$database = 'coinconverter';

$connection = new mysqli($hostname, $username, $password, $database);

if ($connection->connect_error) {
    die("Erro na conexão com o banco de dados: " . $connection->connect_error);
}
?>
