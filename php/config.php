<?php
$conexao = new mysqli('localhost', 'root', '', 'locadorabd', '3312');

if ($conexao->connect_error) {
    die('Erro de conexão(' . $conexao->connect_errno . ') ' . $conexao->connect_error);
}
?>