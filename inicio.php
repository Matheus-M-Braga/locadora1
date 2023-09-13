<?php
session_start();
// teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}
$logado = $_SESSION['email'];

include_once('./php/config.php');

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

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css?<?php echo rand(1, 1000); ?>">
    <link rel="stylesheet" href="css/mediaquery.css?<?php echo rand(1, 1000); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <title>WDA Livraria</title>
</head>

<body>
    <!-- header -->
    <header>
        <nav class="menubar">
            <div class="logo">
                <img src="img/favicon.ico" alt="">
                <a class="title-link" href="inicio.php">WDA Livraria</a>
            </div>
            <div class="links">
                <div class="link">
                    <img src="img/dashboard.png" alt="" class="links_icons">
                    <a href="inicio.php" class="selected">Dashboard</a>
                </div>
                <div class="link">
                    <img src="img/usuarios.png" alt="" class="links_icons">
                    <a href="user.php">Usuários</a>
                </div>
                <div class="link">
                    <img src="img/livros.png" alt="" class="links_icons">
                    <a href="livro.php">Livros</a>
                </div>
                <div class="link">
                    <img src="img/editoras.png" alt="" class="links_icons">
                    <a href="editora.php">Editoras</a>
                </div>
                <div class="link">
                    <img src="img/alugueis.png" alt="" class="links_icons">
                    <a href="aluguel.php">Aluguéis</a>
                </div>
            </div>
            <div class="dropdown">
                <button onclick="toggleDropdown()">Menu</button>
                <ul class="dropdown-content" id="dropdownContent">
                    <li><a href="#" class="selected">Dashboard</a></li>
                    <li><a href="user.php">Usuários</a></li>
                    <li><a href="livro.php">Livros</a></li>
                    <li><a href="editora.php">Edtioras</a></li>
                    <li><a href="aluguel.php">Aluguéis</a></li>
                </ul>
            </div>
            <a href="php/sair.php" id="sair-btn"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
        </nav>
    </header>
    <!-- conteudo -->
    <div class="corpo">
        <main style="overflow-y: auto;">
            <div class="graficos">
                <div id="grafico" class="container bg-light">
                    <div style="text-align:center;">
                        <h2 class="title">Livros mais alugados</h2>
                    </div>
                    <canvas id="grafico01" width="300"></canvas>
                    <div>
                    </div>
                </div>
                <div id="grafico2" class="container bg-light">
                    <div style="text-align:center;">
                        <h2 class="title">Status de Aluguéis</h2>
                    </div>
                    <canvas id="grafico02" width="300" height="200"></canvas>
                    <div>
                    </div>
                </div>
            </div>
            <div class="dash_father">
                <div class="dash_container">
                    <span class="title">Últmo livro alugado:</span>
                    <?php
                    if (isset($ultimo_alugado)) {
                        echo "<span class='content'>" . $ultimo_livro . "</span>";
                    } else {
                        echo "<span class='content'>Aguardando dados...</span>";
                    }
                    ?>
                </div>
                <div class="dash_container">
                    <span class="title">Usuários cadastrados</span>
                    <div class="relat">
                        <p>
                            <?php echo "<span class='content number'> " . $usuarios . "</span>" ?>
                        </p>
                    </div>
                </div>
                <div class="dash_container">
                    <span class="title">Livros cadastrados</span>
                    <div class="relat">
                        <p>
                            <?php echo "<span class='content number'> " . $livros . "</span>" ?>
                        </p>
                    </div>
                </div>
                <div class="dash_container">
                    <span class="title">Editoras cadastradas</span>
                    <div class="relat">
                        <p>
                            <?php echo "<span class='content number'> " . $editoras . "</span>" ?>
                        </p>
                    </div>
                </div>
            </div>
        </main>
        <footer style="display: none;">
            <h1>Origem dos ícones:</h1>
            <a href="https://www.flaticon.com/free-icons/best-seller" title="best seller icons">Best seller created by gungyoga04 - Flaticon</a>
        </footer>
    </div>
    <!-- scripts -->
    <script>
        const ctx = document.getElementById('grafico01');
        const cty = document.getElementById('grafico02');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["<?php echo $nomes[0]; ?>", "<?php echo $nomes[1]; ?>", "<?php echo $nomes[2]; ?>"],
                datasets: [{
                    label: '',
                    data: ["<?php echo $info[0]; ?>", "<?php echo $info[1]; ?>", "<?php echo $info[2]; ?>"],
                    backgroundColor: ['rgba(128, 0, 0)', 'rgb(65, 69, 94)', 'rgb(182, 143, 43)'],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(cty, {
            type: 'pie',
            data: {
                labels: ["Pendentes", "No prazo", "Atrasados"],
                datasets: [{
                    label: '',
                    data: ["<?php echo $pendentes ?>", "<?php echo $noprazo ?>", "<?php echo $atrasados ?>"],
                    backgroundColor: ['rgb(182, 143, 43)', 'rgb(0, 110, 0)', 'rgba(110, 0, 0)', ],
                    borderColor: ['rgb(182, 143, 43)', 'rgb(0, 110, 0)', 'rgba(110, 0, 0)', ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        display: false
                    }
                }
            }
        });
    </script>
    <script src="js/script.js"></script>
</body>

</html>