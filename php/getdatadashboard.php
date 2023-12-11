<?php
include_once('config.php');

// Mais alugados
$resultado_grafico = mysqli_query($conexao, "SELECT * FROM livros WHERE alugados > 0 ORDER BY alugados DESC limit 3");

while ($barra = $resultado_grafico->fetch_assoc()) {
    $nomes[] = $barra['nome'];
    $info[] = $barra['alugados'];
}
if(isset($nomes) && isset($info)){
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

// Último aluguel
$sql_ultimo_aluguel = "SELECT * FROM alugueis ORDER BY id DESC LIMIT 1";
$resultado_ultimo_aluguel = $conexao->query($sql_ultimo_aluguel);
$ultimo_aluguel = $resultado_ultimo_aluguel->fetch_assoc();
if (isset($ultimo_aluguel['livro_id'])) {
    $livro_id = $ultimo_aluguel['livro_id'];
    $result_livro = mysqli_query($conexao, "SELECT nome FROM livros WHERE id = '$livro_id'");
    $livro_data = mysqli_fetch_assoc($result_livro);
}
$lastRented = $livro_data['nome'];

// Total de usuários
$sql_usuarios = "SELECT count(*) AS total_usuarios FROM usuarios";
$resultado_usuarios = $conexao->query($sql_usuarios);
$total_usuarios = $resultado_usuarios->fetch_assoc();
if (isset($total_usuarios['total_usuarios'])) {
    $usuarios = $total_usuarios['total_usuarios'];
}
$usersCount = $usuarios;

// Total de livros
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
