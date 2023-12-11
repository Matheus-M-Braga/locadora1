<?php
session_start();
include_once('php/config.php');
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
    $bosta = mysqli_query($conexao , "SELECT * FROM livros");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    include("components/general/head.php");
    ?>
</head>

<body>
    <?php
    include("components/general/header.php");
    ?>
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
    <?php
    include("components/general/scripts.php");
    ?>
</body>

</html>