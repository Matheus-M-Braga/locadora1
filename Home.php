<?php
session_start();
include_once('php/config.php');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="css/style.css" media="all">
    <link rel="stylesheet" href="css/mediaquery.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>WDA Livraria</title>
</head>

<body>
    <header>
        <nav class="menubar">
            <div class="logo">
                <img src="img/favicon.ico" alt="">
                <a class="title-link" href="Home.php">WDA Livraria</a>
            </div>
            <div class="links">
                <div class="link">
                    <img src="img/dashboard.png" alt="" class="links_icons">
                    <a href="Home.php" class="selected">Dashboard</a>
                </div>
                <div class="link">
                    <img src="img/usuarios.png" alt="" class="links_icons">
                    <a href="User.php" class="">Usuários</a>
                </div>
                <div class="link">
                    <img src="img/livros.png" alt="" class="links_icons">
                    <a href="Book.php" class="">Livros</a>
                </div>
                <div class="link">
                    <img src="img/editoras.png" alt="" class="links_icons">
                    <a href="Publisher.php" class="">Editoras</a>
                </div>
                <div class="link">
                    <img src="img/alugueis.png" alt="" class="links_icons">
                    <a href="Rental.php" class="">Aluguéis</a>
                </div>
            </div>
            <div class="dropdown">
                <button onclick="toggleDropdown()">Menu</button>
                <ul class="dropdown-content" id="dropdownContent">
                    <li><a href="#" class="selected">Dashboard</a></li>
                    <li><a href="User.php" id="">Usuários</a></li>
                    <li><a href="Book.php" id="">Livros</a></li>
                    <li><a href="Publisher.php" id="">Editoras</a></li>
                    <li><a href="Rental.php" id="">Aluguéis</a></li>
                </ul>
            </div>
            <a href="php/logout.php" id="sair-btn"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
        </nav>
    </header>
    <div class="corpo">
        <main style="overflow-y: auto;">
            <div class="graficos">
                <div id="grafico" class="container bg-light">
                    <canvas id="grafico01" width="300"></canvas>
                    <div class="noDataChart" id="grafico1Warnning">Informações sobre <span>Livros mais alugados</span> indisponíveis.</div>
                </div>
                <div id="grafico2" class="container bg-light">
                    <canvas id="grafico02" width="300" height="200"></canvas>
                    <div class="noDataChart" id="grafico2Warnning">Informações sobre <span>Status de Aluguéis</span> indisponíveis.</div>
                </div>
            </div>
            <div class="dash_father">
                <div class="dash_container" id="lastRented">
                    <span class="title">Últmo livro alugado:</span>
                    <span class="content"></span>
                    <div class="aviso content" style="display: none;">Aguardando dados...</div>
                </div>
                <div class="dash_container" id="usersCount">
                    <span class="title">Usuários cadastrados</span>
                    <span class="content"></span>
                    <div class="aviso content" style="display: none;">Aguardando dados...</div>
                </div>
                <div class="dash_container" id="booksCount">
                    <span class="title">Livros cadastrados</span>
                    <span class="content"></span>
                    <div class="aviso content" style="display: none;">Aguardando dados...</div>
                </div>
                <div class="dash_container" id="publishersCount">
                    <span class="title">Editoras cadastradas</span>
                    <span class="content"></span>
                    <div class="aviso content" style="display: none;">Aguardando dados...</div>
                </div>
            </div>
        </main>
        <footer style="display: none;">
            <h1>Origem dos ícones:</h1>
            <a href="https://www.flaticon.com/free-icons/best-seller" title="best seller icons">Best seller created by gungyoga04 - Flaticon</a>
        </footer>
    </div>
    <script type="module" src="js/dashboard.js"></script>
</body>

</html>