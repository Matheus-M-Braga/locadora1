<?php
    session_start();

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)){
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: index.php');
    }
    $logado = $_SESSION['email'];

    include_once('./php/config.php');

    $sqlAluguel = "SELECT livro FROM alugueis";

    $resultadolivro= $conexao -> query($sqlAluguel);

  
    $sql_total_alugueis = "SELECT COUNT(*) AS total_alugueis FROM alugueis";
    $resultado_total_alugueis = $conexao -> query($sql_total_alugueis);

    $linha_total_alugueis = $resultado_total_alugueis -> fetch_assoc();
    
    if(isset($linha_total_alugueis['total_alugueis'])) {
        $quantidade_alugueis = $linha_total_alugueis['total_alugueis'];
    }

    $sql_ultimo_aluguel = "SELECT * FROM alugueis ORDER BY CodAluguel DESC LIMIT 1";
    $resultado_ultimo_aluguel = $conexao->query($sql_ultimo_aluguel);

    $ultimo_alugado = $resultado_ultimo_aluguel -> fetch_assoc();

    if(isset($ultimo_alugado['livro'])){
        $ultimo_livro = $ultimo_alugado['livro'];
    }

    $sql_mais_alugado = "SELECT livro FROM alugueis WHERE livro = livro GROUP BY livro ORDER BY COUNT(livro) DESC LIMIT 1";
    $resultado_mais_alugado = $conexao -> query($sql_mais_alugado);
    $mais_alugado = $resultado_mais_alugado -> fetch_assoc();
    if(isset( $mais_alugado['livro'])){
        $mais_alug =  $mais_alugado['livro'];
    }

    $sql_total_livros = "SELECT sum(quantidade) AS total_livros FROM livros";
    $resultado_total_livros = $conexao->query($sql_total_livros);
    $total_livros=$resultado_total_livros->fetch_assoc();

    if(isset($total_livros['total_livros'])){
        $totais_livros = $total_livros['total_livros'];
    }

    $sql_nao_devolvidos = "SELECT count(data_devolucao) as nao_devolvidos FROM alugueis where data_devolucao = 0";
    $resultado_nao_devolvidos = $conexao -> query($sql_nao_devolvidos);
    $total_nao_devo = $resultado_nao_devolvidos -> fetch_assoc();
    if(isset($total_nao_devo['nao_devolvidos'])){
        $total_nao_devo = $total_nao_devo['nao_devolvidos'];
    }

    $sql_devo = "SELECT count(data_devolucao) as devolvidos FROM alugueis where data_devolucao!=0";
    $resultado_devo = $conexao -> query($sql_devo);
    $total_devo = $resultado_devo -> fetch_assoc();
    if(isset($total_devo['devolvidos'])){
        $total_devol= $total_devo['devolvidos'];
    }

    $sql_grafico = "SELECT livro, count(livro) as quantidade_aluguel FROM alugueis WHERE livro = livro GROUP BY livro ORDER BY COUNT(livro) DESC limit 3";
    $resultado_grafico= $conexao -> query($sql_grafico);

    while($barra=$resultado_grafico -> fetch_assoc()){
        $nomes[]=$barra['livro'];
        $info[]=$barra['quantidade_aluguel'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/f4c3c17e91.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css?<?php echo rand(1, 1000); ?>">
    <link rel="stylesheet" href="css/mediaquery.css?<?php echo rand(1, 1000); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <title>WDA Livraria</title>
</head>
<body>
<!-- header -->
<header>
    <nav class="menubar">
        <div class="logo">
            <a class="title-link" href="inicio.php">WDA Livraria</a>
        </div>
        <div class="links">
            <a href="inicio.php" class="selected">Dashboard</a>
            <a href="user.php">Usuários</a>
            <a href="livro.php">Livros</a>
            <a href="editora.php">Editoras</a>
            <a href="aluguel.php">Aluguéis</a>
        </div>
        <a href="php/sair.php"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
    </nav>
</header>
<!-- conteudo -->
<div class="corpo">
    <main>
        <div class="graficos">
            <div id="grafico" class="container bg-light">
                <div style="text-align:center;">
                    <h2>Livros mais alugados: </h2>
                </div>
                <canvas id="grafico01" width="300" style="margin-top:-6px;"></canvas>
                <div>
                </div>
            </div>
            <div id="grafico2" class="container bg-light" style="width: 31%;">
                <div style="text-align:center;">
                    <h2>Livros Disponíveis</h2>
                </div>
                <canvas id="grafico02" width="300" height="200" style="margin-top:-6px;"></canvas>
                <div>
                </div>
            </div>
        </div>
        <div class="dash_father">
            <div class="dash_container">
                <span class="title">Livro mais alugado</span>
                <?php if(isset($mais_alug)){
                    echo "<span class='content'> <img src='img/top1.png' alt=''>".$mais_alug."</span>";
                }
                else{
                    echo " <span class='content'>Aguardando dados...</span> ";
                }
                ?>
            </div>
            <div class="dash_container">
                <span class="title">Livros Disponíveis</span>
                <div class="relat">
                    <p>
                        <?php echo "<span class='content number'> <img src='img/books.png' alt=''>".$totais_livros."</span>" ?>
                    </p>
                </div>
            </div>
            <div class="dash_container">
                <span class="title">Status dos Aluguéis:</span>
                <?php echo  "<span class='content'> Devolvidos: ".$total_devol."</span>"; ?>
                <?php echo"<span class='content'> Pendentes: ".$total_nao_devo."</span>"; ?>
            </div>
            <div class="dash_container">
                <span class="title">Últmo livro alugado:</span>
                <?php
                    if(isset($ultimo_alugado)){
                        echo "<span class='content'> <img src='img/book.png' alt=''>".$ultimo_livro."</span>";
                    }
                    else{
                        echo "<span class='content'>Aguardando dados...</span>";
                    }
                ?>
            </div>
        </div>
    </main>
    <footer style="display: none;">
        <h1>Origem dos ícones:</h1>
        <a href="https://www.flaticon.com/free-icons/best-seller" title="best seller icons">Best seller  created by gungyoga04 - Flaticon</a>
    </footer>
</div>
<!-- scripts -->
<script>
    const ctx = document.getElementById('grafico01');
    const cty = document.getElementById('grafico02');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [ "<?php  echo $nomes[0]; ?>","<?php  echo $nomes[1]; ?>","<?php  echo $nomes[2]; ?>"],
            datasets: [{
                label: 'Mais Alugados',
                data: ["<?php echo $info[0]; ?>","<?php echo $info[1]; ?>","<?php echo $info[2]; ?>"],
                backgroundColor: ['rgba(128, 0, 0)','rgb(65, 69, 94)','rgb(182, 143, 43)'],
                borderWidth: 0
            }]
        },
        options: {
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
            labels: [ "<?php  echo $nomes[0]; ?>","<?php  echo $nomes[1]; ?>","<?php  echo $nomes[2]; ?>"],
            datasets: [{
                label: 'Mais Alugados',
                data: ["<?php echo $info[0]; ?>","<?php echo $info[1]; ?>","<?php echo $info[2]; ?>"],
                backgroundColor: ['rgba(128, 0, 0)','rgb(65, 69, 94)','rgb(182, 143, 43)'],
                borderWidth: 0
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script src="js/script.js"></script>
</body>
</html>