<?
include_once('config.php');

$sqlAluguel = "SELECT livro FROM alugueis";

$resultadolivro = $conexao->query($sqlAluguel);

// mais alugados
$sql_grafico = "SELECT livro, count(livro) as quantidade_aluguel FROM alugueis WHERE livro = livro GROUP BY livro ORDER BY COUNT(livro) DESC limit 3";
$resultado_grafico = $conexao->query($sql_grafico);

while ($barra = $resultado_grafico->fetch_assoc()) {
    $nomes[] = $barra['livro'];
    $info[] = $barra['quantidade_aluguel'];
}

// total de aluguéis
$sql_total_alugueis = "SELECT COUNT(*) AS total_alugueis FROM alugueis";
$resultado_total_alugueis = $conexao->query($sql_total_alugueis);

$linha_total_alugueis = $resultado_total_alugueis->fetch_assoc();

if (isset($linha_total_alugueis['total_alugueis'])) {
    $quantidade_alugueis = $linha_total_alugueis['total_alugueis'];
}

// aluguéis pendentes
$sql_pendentes = "SELECT count(status) as pendentes FROM alugueis where status = 'Pendente'";
$resultado_pendentes = $conexao->query($sql_pendentes);
$total_pendentes = $resultado_pendentes->fetch_assoc();
if (isset($total_pendentes['pendentes'])) {
    $pendentes = $total_pendentes['pendentes'];
}

// aluguéis entregues no prazo
$sql_noprazo = "SELECT count(status) as noprazo FROM alugueis where status = 'No prazo'";
$resultado_noprazo = $conexao->query($sql_noprazo);
$total_noprazo = $resultado_noprazo->fetch_assoc();
if (isset($total_noprazo['noprazo'])) {
    $noprazo = $total_noprazo['noprazo'];
}

// aluguéis entregues com atraso
$sql_atrasados = "SELECT count(status) as atrasados FROM alugueis where status = 'Atrasado'";
$resultado_atrasados = $conexao->query($sql_atrasados);
$total_atrasados = $resultado_atrasados->fetch_assoc();
if (isset($total_atrasados['atrasados'])) {
    $atrasados = $total_atrasados['atrasados'];
}

// último aluguel
$sql_ultimo_aluguel = "SELECT * FROM alugueis ORDER BY id DESC LIMIT 1";
$resultado_ultimo_aluguel = $conexao->query($sql_ultimo_aluguel);
$ultimo_alugado = $resultado_ultimo_aluguel->fetch_assoc();
if (isset($ultimo_alugado['livro'])) {
    $ultimo_livro = $ultimo_alugado['livro'];
}

// Total de usuários
$sql_usuarios = "SELECT count(*) AS total_usuarios FROM usuarios";
$resultado_usuarios = $conexao->query($sql_usuarios);
$total_usuarios = $resultado_usuarios->fetch_assoc();
if (isset($total_usuarios['total_usuarios'])) {
    $usuarios = $total_usuarios['total_usuarios'];
}

// total de livros
$sql_total_livros = "SELECT sum(quantidade) AS total_livros FROM livros";
$resultado_total_livros = $conexao->query($sql_total_livros);
$total_livros = $resultado_total_livros->fetch_assoc();
if (isset($total_livros['total_livros'])) {
    $livros = $total_livros['total_livros'];
}

// Total de editoras
$sql_editoras = "SELECT count(*) AS total_editoras FROM editoras";
$resultado_editoras = $conexao->query($sql_editoras);
$total_editoras = $resultado_editoras->fetch_assoc();
if (isset($total_editoras['total_editoras'])) {
    $editoras = $total_editoras['total_editoras'];
}