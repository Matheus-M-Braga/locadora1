<?php
session_start();

include_once('php/config.php');
date_default_timezone_set('America/Sao_Paulo');
// Teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}
$logado = $_SESSION['email'];

// Pesquisa
if (!empty($_GET['search'])) {
    $data = $_GET['search'];

    $sql = "SELECT * FROM alugueis WHERE id LIKE '%$data%' OR livro LIKE '%$data%' or usuario LIKE '%$data%' OR data_aluguel LIKE '%$data%' OR prev_devolucao LIKE '%$data%' OR data_devolucao LIKE '%$data%' ORDER BY id ASC";
} else {
    $sql = "SELECT * FROM alugueis ORDER BY id ASC";
}
$result = $conexao->query($sql);

// Número de registros por página
$registrosPorPagina = 5;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Select com os parâmetros
$result = $conexao->query($sql);
$totalRegistros = $result->num_rows;
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
if (!empty($search)) {
    $sqlsearch = "SELECT * FROM alugueis WHERE id LIKE '%$data%' OR livro LIKE '%$data%' or usuario LIKE '%$data%' OR data_aluguel LIKE '%$data%' OR prev_devolucao LIKE '%$data%' OR data_devolucao LIKE '%$data%' ORDER BY id ASC";
    $result = $conexao->query($sqlsearch);
} else {
    $sql = "SELECT * FROM alugueis ORDER BY id ASC LIMIT $registrosPorPagina OFFSET $offset";
    $result = $conexao->query($sql);
}

// Conexão tabela Livros
$sqllivro_conect = "SELECT * FROM livros ORDER BY id ASC";
$resultlivro_conect = $conexao->query($sqllivro_conect);

// Conexão tabela Usuários
$sqluser_conect = "SELECT * FROM usuarios ORDER BY id ASC";
$resultuser_conect = $conexao->query($sqluser_conect);

// Cálculo datepicker
$hoje = new DateTime();
$hojeMais30 = (clone $hoje)->add(new DateInterval('P30D'));
$hojeFormatado = $hoje->format('Y-m-d');
$hojeMais30Formatado = $hojeMais30->format('Y-m-d');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/f4c3c17e91.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="css/mediaquery.css?<?php echo rand(1, 1000); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script>
        var search = document.getElementById('pesquisadora')
        search.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        })

        function searchData() {
            window.location = "user.php?search=" = search.value
        }
    </script>
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
                    <a href="inicio.php">Dashboard</a>
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
                    <a href="aluguel.php" class="selected">Aluguéis</a>
                </div>
            </div>
            <div class="dropdown">
                <button onclick="toggleDropdown()">Menu</button>
                <ul class="dropdown-content" id="dropdownContent">
                    <li><a href="inicio.php">Dashboard</a></li>
                    <li><a href="user.php">Usuários</a></li>
                    <li><a href="livro.php">Livros</a></li>
                    <li><a href="editora.php">Edtioras</a></li>
                    <li><a href="aluguel.php" class="selected">Aluguéis</a></li>
                </ul>
            </div>
            <a href="php/sair.php" id="sair-btn"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
        </nav>
    </header>
    <div class="corpo">
        <main>
            <!-- modal -->
            <div id="vis-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <class class="top_modal">
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastro do Aluguel</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </class>
                    <form action=".create/create-aluguel.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black">Livro Alugado</label>
                                <select name="nome-livro" class="form-control form-select needs-validation is-invalid" id="input1" required>
                                    <option value="" selected disabled>Selecione:</option>
                                    <?php
                                    while ($livro_data = mysqli_fetch_assoc($resultlivro_conect)) {
                                        echo "<option>" . $livro_data['nome'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">Usuário</label>
                                <select name="usuario" class="form-control form-select needs-validation is-invalid" id="input2" required>
                                    <option value="" selected disabled>Selecione:</option>
                                    <?php
                                    while ($user_data = mysqli_fetch_assoc($resultuser_conect)) {
                                        echo "<option>" . $user_data['nome'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="row-md-3">
                                <label for="input3" class="form-label text-black">Data do Aluguel (Hoje)</label>
                                <input name="dat_aluguel" type="date" id="input3" class="form-control" value="<?php echo $hojeFormatado ?>" disabled required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Campo obrigatório •
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input4" class="form-label text-black">Previsão de Devolução</label>
                                <input name="prev_devolucao" type="date" min="<?php echo $hojeFormatado ?>" max="<?php echo $hojeMais30Formatado ?>" id="input4" class="form-control date" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    • Informe a data de devolução
                                </div>
                            </div>
                            <input type="hidden" name="data_devolucao" value="0">
                            <div class="col-12" style="text-align: center;">
                                <button class="btn btn-success" type="submit" name="submit">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal devol-->
            <div id="devol-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck titulo_modal">Devolver Livro</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('devol-modal')">
                    </div>
                    <div class="iconDel">
                        <img src="img/book-check.png" alt="">
                    </div>
                    <p>Tem certeza que deseja devolver o livro do aluguel selecionado?</p>
                    <div class="col-12" style="text-align: center;">
                        <button class="btn btn-danger" type="reset" onclick="fecharModal('devol-modal')">Cancelar</button>
                        <button class="btn btn-success confirm_devol" type="submit" name="devol" id="devolver">Devolver</button>
                    </div>
                </div>
            </div>
            <!-- Modal exclu -->
            <div id="exclu-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck titulo_modal">Excluir Aluguel</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('exclu-modal')">
                    </div>
                    <div class="iconDel">
                        <img src="img/aviso.png" alt="">
                    </div>
                    <p>Tem certeza que deseja excluir o aluguel selecionado?</p>
                    <div class="col-12" style="text-align: center;">
                        <button class="btn btn-success" type="reset" onclick="fecharModal('exclu-modal')">Cancelar</button>
                        <button class="btn btn-danger confirm_exclu" type="submit" name="delete" id="excluir">Excluir</button>
                    </div>
                </div>
            </div>
            <!-- GRID -->
            <div class="grid-header">
                <div class="wrapper">
                    <span class="titulo-pg">Aluguéis</span>
                    <div class="novobtn" onclick="abrirModal('vis-modal'); resetForm('vis-modal');">NOVO <span class="material-symbols-outlined">add</span></div>
                </div>
                <form class="searchbox sbx-custom" id="search-alug">
                    <div role="search" class="sbx-custom__wrapper">
                        <span class="material-symbols-outlined search">search</span>
                        <input type="search" name="search" placeholder="Pesquisar..." autocomplete="off" class="sbx-custom__input" id="pesquisadora">
                    </div>
                </form>
            </div>
            <div class="grid-body">
                <?php
                // Montagem da grid (incrível)
                $dados = "<table class='container-grid'>
                    <thead>
                        <tr>
                            <th class='titulos'>ID</th>
                            <th class='titulos'>LIVRO</th>
                            <th class='titulos'>USUÁRIO</th>
                            <th class='titulos'>ALUGUEL</th>
                            <th class='titulos'>PREVISÃO</th>
                            <th class='titulos'>DEVOLUÇÃO</th>
                            <th class='titulos'>STATUS</th>
                            <th class='titulos'>AÇÕES</th>
                        </tr>
                    </thead><tbody>";
                echo $dados;
                while ($aluguel_data = mysqli_fetch_assoc($result)) {
                    // Datas para serem exibidas no padrão d/m/Y na tabela
                    $alug_dat = date("d/m/Y", strtotime($aluguel_data['data_aluguel']));
                    $prev_dat = date("d/m/Y", strtotime($aluguel_data['prev_devolucao']));
                    $dev_dat = date("d/m/Y", strtotime($aluguel_data['data_devolucao']));

                    // Para comparação
                    $comp_previsao = $aluguel_data['prev_devolucao'];
                    $comp_devolucao = $aluguel_data['data_devolucao'];

                    if($aluguel_data['data_devolucao'] == 0){
                        $status = "Pendente";
                    } else if($comp_devolucao <= $comp_previsao){
                        $status = "No prazo";
                    } else if($comp_devolucao > $comp_previsao){
                        $status = "Atrasado";
                    }

                    echo "
                    <tr>
                        <td class='itens'>" . $aluguel_data['id'] . "</td>"
                        . "<td class='itens'>" . $aluguel_data['livro'] . "</td>"
                        . "<td class='itens'>" . $aluguel_data['usuario'] . "</td>"
                        . "<td class='itens'>" . $alug_dat . "</td>"
                        . "<td class='itens'>" . $prev_dat . "</td>";
                    if ($aluguel_data['data_devolucao'] == 0) {
                        echo "<td class='itens'>...</td>"
                            . "<td class='itens'>" . $status . "</td>";
                        echo "<td class='itens'>
                            <img src='img/check.png' alt='Devolver' title='Devolver' data-id='$aluguel_data[id]'  class='devol' onclick=" . "abrirModal('devol-modal')" . ">
                            <img src='img/bin.png' data-id='$aluguel_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                            </td></tr>";
                    } else {
                        $hoje = date("Y/m/d");
                        $previsao = $aluguel_data['prev_devolucao'];
                        echo "<td class='itens'>" . $dev_dat . "</td>"
                            . "<td class='itens'>" . $status . "</td>";
                        echo "<td class='itens'><img src='img/bin.png' data-id='$aluguel_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'></td></tr>";
                    }
                }
                echo "</tbody></table>";
                ?>
                <!-- Área da paginação -->
                <div class="pagination 
                <?php if (!empty($search)) {
                    echo 'd-none';
                } ?>">
                    <!-- Guia da paginação-->
                    <ul class="pagination">
                        <li class="page-item <?php echo ($paginaAtual == 1) ? '' : ''; ?>">
                            <a class="page-link" href="aluguel.php?pagina=1" aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                        // Exibir link da página anterior, se existir
                        if ($paginaAtual > 4) {
                            echo "<li class='page-item'><a class='page-link' href='aluguel.php?pagina=1'>1</a></li>";
                        }
                        // Exibir páginas anteriores à página atual
                        if ($paginaAtual == $totalPaginas) {
                            for ($i = max(1, $paginaAtual - 2); $i < $paginaAtual; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='aluguel.php?pagina=$i'>$i</a></li>";
                            }
                        } else {
                            for ($i = max(1, $paginaAtual - 1); $i < $paginaAtual; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='aluguel.php?pagina=$i'>$i</a></li>";
                            }
                        }
                        // Exibir página atual
                        echo "<li class='page-item active'><span class='page-link'>$paginaAtual</span></li>";
                        // Exibir páginas posteriores à página atual
                        if ($paginaAtual == 1) {
                            for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 2, $totalPaginas); $i++) {
                                echo "<li class='page-item'><a class='page-link' href='aluguel.php?pagina=$i'>$i</a></li>";
                            }
                        } else {
                            for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 1, $totalPaginas); $i++) {
                                echo "<li class='page-item'><a class='page-link' href='aluguel.php?pagina=$i'>$i</a></li>";
                            }
                        }
                        ?>
                        <li class="page-item <?php echo ($paginaAtual == $totalPaginas) ? '' : ''; ?>">
                            <a class="page-link" href="aluguel.php?pagina=<?php echo $totalPaginas; ?>" aria-label="Próxima">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    <!-- scripts -->
    <script src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'php/getdataAlug.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('.exclu').click(function() {
                        var btnID = $(this).data('id')

                        $('.confirm_exclu').click(function() {
                            window.location.href = ".delete/delet-aluguel.php" + "?id=" + btnID;
                        })
                    })
                    $('.devol').click(function() {
                        var btnID = $(this).data('id')

                        $('.confirm_devol').click(function() {
                            window.location.href = ".update/update-aluguel.php" + "?id=" + btnID;
                        })
                    })
                },
                error: function(xhr, status, error) {
                    console.error('Erro na solicitação AJAX: ' + status + ' - ' + error);
                }
            });
        });
    </script>
</body>

</html>