<?php
session_start();
// teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}
$logado = $_SESSION['email'];
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