<?php
include_once('config.php');

$sqlAluguel = "SELECT livro FROM alugueis";

$resultadolivro = $conexao->query($sqlAluguel);

$sql_grafico = "SELECT livro, count(livro) as quantidade_aluguel FROM alugueis WHERE livro = livro GROUP BY livro ORDER BY COUNT(livro) DESC limit 3";
$resultado_grafico = $conexao->query($sql_grafico);

while ($barra = $resultado_grafico->fetch_assoc()) {
    $nomes[] = $barra['livro'];
    $info[] = $barra['quantidade_aluguel'];
}
$mostRented = array(
    'nomes' => $nomes,
    'infos' => $info
);

$sql_status = "SELECT
    COUNT(CASE WHEN status = 'Pendente' THEN 1 END) AS pendentes,
    COUNT(CASE WHEN status = 'No prazo' THEN 1 END) AS noprazo,
    COUNT(CASE WHEN status = 'Atrasado' THEN 1 END) AS atrasados
FROM alugueis";

$resultado_status = $conexao->query($sql_status);

if ($resultado_status) {
    $row = $resultado_status->fetch_assoc();
    $pendentes = $row['pendentes'] ?? 0;
    $noprazo = $row['noprazo'] ?? 0;
    $atrasados = $row['atrasados'] ?? 0;
}
$rentalStatus = array(
    "pendentes" => $pendentes,
    "noprazo" => $noprazo,
    "atrasados" => $atrasados
);

// último aluguel
$sql_ultimo_aluguel = "SELECT * FROM alugueis ORDER BY id DESC LIMIT 1";
$resultado_ultimo_aluguel = $conexao->query($sql_ultimo_aluguel);
$ultimo_alugado = $resultado_ultimo_aluguel->fetch_assoc();
if (isset($ultimo_alugado['livro'])) {
    $ultimo_livro = $ultimo_alugado['livro'];
}
$lastRented = $ultimo_livro;

// Total de usuários
$sql_usuarios = "SELECT count(*) AS total_usuarios FROM usuarios";
$resultado_usuarios = $conexao->query($sql_usuarios);
$total_usuarios = $resultado_usuarios->fetch_assoc();
if (isset($total_usuarios['total_usuarios'])) {
    $usuarios = $total_usuarios['total_usuarios'];
}
$usersCount = $usuarios;

// total de livros
$sql_total_livros = "SELECT sum(quantidade) AS total_livros FROM livros";
$resultado_total_livros = $conexao->query($sql_total_livros);
$total_livros = $resultado_total_livros->fetch_assoc();
if (isset($total_livros['total_livros'])) {
    $livros = $total_livros['total_livros'];
}
$booksCount = $livros;

// Total de editoras
$sql_editoras = "SELECT count(*) AS total_editoras FROM editoras";
$resultado_editoras = $conexao->query($sql_editoras);
$total_editoras = $resultado_editoras->fetch_assoc();
if (isset($total_editoras['total_editoras'])) {
    $editoras = $total_editoras['total_editoras'];
}
$publishersCount = $editoras;

// Armazena todas as consultas
$DashData = array(
    "mostRented" => $mostRented,
    "rentalStatus" => $rentalStatus,
    "lastRented" => $lastRented,
    "usersCount" => $usersCount,
    "booksCount" => $booksCount,
    "publishersCount" => $publishersCount
);
echo json_encode($DashData);