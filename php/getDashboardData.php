<?php
include_once('config.php');

// Mais alugados
$resultado_grafico = mysqli_query($conexao, "SELECT * FROM livros WHERE alugados > 0 ORDER BY alugados DESC limit 3");
while ($barra = $resultado_grafico->fetch_assoc()) {
    $nomes[] = $barra['nome'];
    $info[] = $barra['alugados'];
}
if (isset($nomes) && isset($info)) {
    $mostRented = array(
        'nomes' => $nomes,
        'infos' => $info
    );
} else {
    $mostRented = array(
        'nomes' => null,
        'infos' => null
    );
}

// Status
$resultado_status = mysqli_query($conexao, "SELECT
COUNT(CASE WHEN status = 'Pendente' THEN 1 END) AS pendentes,
COUNT(CASE WHEN status = 'No prazo' THEN 1 END) AS noprazo,
COUNT(CASE WHEN status = 'Atrasado' THEN 1 END) AS atrasados
FROM alugueis");
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

// Último aluguel
$resultado_ultimo_aluguel = mysqli_query($conexao, "SELECT * FROM alugueis ORDER BY id DESC LIMIT 1");
$ultimo_aluguel = $resultado_ultimo_aluguel->fetch_assoc();
if (isset($ultimo_aluguel['livro_id'])) {
    $livro_id = $ultimo_aluguel['livro_id'];
    $result_livro = mysqli_query($conexao, "SELECT nome FROM livros WHERE id = '$livro_id'");
    $livro_data = mysqli_fetch_assoc($result_livro);
}
if (isset($livro_data)) {
    $lastRented = $livro_data['nome'];
} else {
    $lastRented = null;
}

// Total de usuários
$resultado_usuarios = mysqli_query($conexao, "SELECT count(*) AS total_usuarios FROM usuarios");
$total_usuarios = $resultado_usuarios->fetch_assoc();
if (isset($total_usuarios['total_usuarios'])) {
    $usuarios = $total_usuarios['total_usuarios'];
}
$usersCount = $usuarios;

// Total de livros
$resultado_total_livros = mysqli_query($conexao, "SELECT sum(quantidade) AS total_livros FROM livros");
$total_livros = $resultado_total_livros->fetch_assoc();
if (isset($total_livros['total_livros'])) {
    $livros = $total_livros['total_livros'];
}
$booksCount = $livros;

// Total de editoras
$resultado_editoras = mysqli_query($conexao, "SELECT count(*) AS total_editoras FROM editoras");
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
