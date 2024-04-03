<?php
include_once('config.php');

// Mais alugados
$resultado_grafico = mysqli_query($conexao, "SELECT nome, alugados FROM livros WHERE alugados > 0 ORDER BY alugados DESC LIMIT 3");
if ($resultado_grafico) {
    $nomes = array();
    $info = array();
    while ($barra = $resultado_grafico->fetch_assoc()) {
        $nomes[] = $barra['nome'];
        $info[] = $barra['alugados'];
    }
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
} else {
    $pendentes = 0;
    $noprazo = 0;
    $atrasados = 0;
}
$rentalStatus = array(
    "pendentes" => $pendentes,
    "noprazo" => $noprazo,
    "atrasados" => $atrasados
);

// Último aluguel
$resultado_ultimo_aluguel = mysqli_query($conexao, "SELECT livro_id FROM alugueis ORDER BY id DESC LIMIT 1");
if ($resultado_ultimo_aluguel && $resultado_ultimo_aluguel->num_rows > 0) {
    $ultimo_aluguel = $resultado_ultimo_aluguel->fetch_assoc();
    $livro_id = $ultimo_aluguel['livro_id'];
    $result_livro = mysqli_query($conexao, "SELECT nome FROM livros WHERE id = '$livro_id'");
    if ($result_livro && $result_livro->num_rows > 0) {
        $livro_data = mysqli_fetch_assoc($result_livro);
        $lastRented = $livro_data['nome'];
    } else {
        $lastRented = null;
    }
} else {
    $lastRented = null;
}

// Total de usuários
$resultado_usuarios = mysqli_query($conexao, "SELECT count(*) AS total_usuarios FROM usuarios");
if ($resultado_usuarios) {
    $total_usuarios = $resultado_usuarios->fetch_assoc();
    $usuarios = $total_usuarios['total_usuarios'] ?? 0;
} else {
    $usuarios = 0;
}
$usersCount = $usuarios;

// Total de livros
$resultado_total_livros = mysqli_query($conexao, "SELECT sum(quantidade) AS total_livros FROM livros");
if ($resultado_total_livros) {
    $total_livros = $resultado_total_livros->fetch_assoc();
    $livros = $total_livros['total_livros'] ?? 0;
} else {
    $livros = 0;
}
$booksCount = $livros;

// Total de editoras
$resultado_editoras = mysqli_query($conexao, "SELECT count(*) AS total_editoras FROM editoras");
if ($resultado_editoras) {
    $total_editoras = $resultado_editoras->fetch_assoc();
    $editoras = $total_editoras['total_editoras'] ?? 0;
} else {
    $editoras = 0;
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

// Configura o cabeçalho para JSON
header('Content-Type: application/json');

// Retorna os dados como JSON
echo json_encode($DashData);
?>
