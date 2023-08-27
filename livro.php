<?php
session_start();

include_once('php/config.php');

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

    $sql = "SELECT * FROM livros WHERE CodLivro LIKE '%$data%'OR nome LIKE '%$data%' or autor LIKE '%$data%' or editora LIKE '%$data%' OR lancamento LIKE '%$data%' or quantidade LIKE '%$data%' ORDER BY CodLivro ASC";
} else {
    $sql = "SELECT * FROM livros ORDER BY CodLivro ASC";
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
    $sqlsearch = "SELECT * FROM livros WHERE CodLivro LIKE '%$data%'OR nome LIKE '%$data%' OR autor LIKE '%$data%' or editora LIKE '%$data%' OR lancamento LIKE '%$data%' or quantidade LIKE '%$data%' ORDER BY CodLivro ASC";
    $result = $conexao->query($sqlsearch);
} else {
    $sql = "SELECT * FROM livros ORDER BY CodLivro ASC LIMIT $registrosPorPagina OFFSET $offset";
    $result = $conexao->query($sql);
}

// Conexão tabela editoras
$sqlEditoras_conect = "SELECT * FROM editoras ORDER BY CodEditora ASC";
$resultEditora_conect = $conexao->query($sqlEditoras_conect);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="css/mediaquery.css?<?php echo rand(1, 1000); ?>">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <a href="livro.php" class="selected">Livros</a>
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
                    <li><a href="inicio.php">Dashboard</a></li>
                    <li><a href="user.php">Usuários</a></li>
                    <li><a href="livro.php" class="selected">Livros</a></li>
                    <li><a href="editora.php">Edtioras</a></li>
                    <li><a href="aluguel.php">Aluguéis</a></li>
                </ul>
            </div>
            <a href="php/sair.php" id="sair-btn"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
        </nav>
    </header>
    <div class="corpo">
        <main>
            <!-- Modal -->
            <div id="vis-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastro do Livro</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </div>
                    <form action=".create/create-livro.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black bold">Nome</label>
                                <input name="nome-livro" type="text" class="form-control" id="input1" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Campo obrigatório •
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">Autor</label>
                                <input name="autor" type="text" class="form-control" id="input2" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Campo obrigatório •
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input5" class="form-label text-black">Quantidade</label>
                                <input name="quantidade" type="number" class="form-control" id="input5" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Campo obrigatório •
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input4" class="form-label text-black">Lançamento</label>
                                <input name="lancamento" type="date" class="form-control date" id="input4" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Campo obrigatório •
                                </div>
                            </div>
                        </div>
                        <div class="row-md-3">
                            <label for="input3" class="form-label text-black">Editora</label>
                            <select name="editora" class="form-select needs-validation is-invalid" id="input3" required>
                                <option value="" selected disabled>Selecione:</option>
                                <?php
                                while ($editora_data = mysqli_fetch_assoc($resultEditora_conect)) {
                                    echo "<option value='{$editora_data['nome']}'>{$editora_data['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12" style="text-align: center;">
                            <button class="btn btn-success" type="submit" name="submit">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal edit -->
            <div id="edit-modal" class="modal">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Editar Livro</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('edit-modal')">
                    </div>
                    <form action=".update/update-livro.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id" id="campo1">
                        <div class="row-md-3">
                            <label for="campo2" class="form-label text-black bold">Nome</label>
                            <input name="nome-livro" type="text" class="form-control" id="campo2" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Campo obrigatório •
                            </div>
                        </div>
                        <div class="row-md-3">
                            <label for="campo3" class="form-label text-black">Autor</label>
                            <input name="autor" type="text" class="form-control" id="campo3" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Campo obrigatório •
                            </div>
                        </div>

                        <div class="row-md-3">
                            <label for="campo6" class="form-label text-black">Quantidade</label>
                            <input name="quantidade" type="number" class="form-control" id="campo6" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Campo obrigatório •
                            </div>
                        </div>
                        <div class="row-md-3">
                            <label for="campo4" class="form-label text-black">Editora</label>
                            <!-- <input type="hidden" name="teste" id="campo4"> -->
                            <select title="fodase" name="editora" class="form-select needs-validation is-invalid" required>
                                <?php
                                $sqllivro = "SELECT * FROM livros WHERE nome = '$nomeLivro' AND autor = '$autor'";
                                $resultado = $conexao->query($sqllivro);
                                $sqlEditoras_conect = "SELECT * FROM editoras ORDER BY CodEditora ASC";
                                $resultEditora_conect = $conexao->query($sqlEditoras_conect);

                                while ($editora_data = mysqli_fetch_assoc($resultEditora_conect)) {
                                    echo "<option value='{$editora_data['nome']}'>{$editora_data['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row-md-3">
                            <label for="campo5" class="form-label text-black">Lançamento</label>
                            <input name="lancamento" type="date" class="form-control date" id="campo5" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Campo obrigatório •
                            </div>
                        </div>
                        <div class="col-12" style="text-align: center;">
                            <button class="btn btn-success" type="submit" name="update">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal exclu -->
            <div id="exclu-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck titulo_modal">Excluir Livro</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('exclu-modal')">
                    </div>
                    <div class="iconDel">
                        <img src="img/aviso.png" alt="">
                    </div>
                    <p>Tem certeza que deseja excluir o livro selecionado?</p>
                    <div class="col-12" style="text-align: center;">
                        <button class="btn btn-success" type="reset" onclick="fecharModal('exclu-modal')">Cancelar</button>
                        <button class="btn btn-danger confirm_exclu" type="submit" name="delete" id="excluir">Excluir</button>
                    </div>
                </div>
            </div>
            <!-- Script da validação -->
            <script>
                (function() {
                    'use strict'
                    var forms = document.querySelectorAll('.needs-validation')
                    Array.prototype.slice.call(forms)
                        .forEach(function(form) {
                            form.addEventListener('submit', function(event) {
                                if (!form.checkValidity()) {
                                    event.preventDefault()
                                    event.stopPropagation()
                                }
                                form.classList.add('was-validated')
                            }, false)
                        })
                })()
            </script>
            <!-- GRID -->
            <div class="grid-header">
                <div class="wrapper">
                    <span class="titulo-pg">Livros</span>
                    <div class="novobtn" onclick="abrirModal('vis-modal')">NOVO <span class="material-symbols-outlined">add</span></div>
                </div>
                <form class="searchbox sbx-custom" id="search-livro">
                    <div role="search" class="sbx-custom__wrapper">
                        <span class="material-symbols-outlined search">search</span>
                        <input type="search" name="search" placeholder="Pesquisar..." autocomplete="off" class="sbx-custom__input" id="pesquisadora">
                    </div>
                </form>
            </div>
            <div class="grid-body">
                <?php
                // Montagem da grid (foda)
                $dados = "<table class='container-grid'>
                <thead>
                    <tr>
                        <th class='titulos'>ID</th>
                        <th class='titulos'>NOME</th>
                        <th class='titulos'>AUTOR</th>
                        <th class='titulos'>EDITORA</th>
                        <th class='titulos'>LANÇAMENTO</th>
                        <th class='titulos'>QUANTIDADE</th>
                        <th class='titulos'>ALUGADOS</th>
                        <th class='titulos'>AÇÕES</th>
                    </tr>
                </thead><tbody>";
                echo $dados;
                $identifier = -1;
                while ($livro_data = mysqli_fetch_assoc($result)) {
                    $identifier++;
                    $lanca = date("d/m/Y", strtotime($livro_data['lancamento']));
                    $nome_livro = $livro_data['nome'];
                    $id = $livro_data['CodLivro'];
                    // Conexão tabela alugueis
                    $sqlAluguelConect = "SELECT * FROM alugueis WHERE livro = '$nome_livro' AND data_devolucao = 0";
                    $sqlAluguelResult = $conexao->query($sqlAluguelConect);
                    $livro_data['alugados'] = $sqlAluguelResult->num_rows;
                    $aluguel_quant = $livro_data['alugados'];
                    mysqli_query($conexao, "UPDATE livros SET alugados = '$aluguel_quant' WHERE CodLivro = '$id' ");
                    echo "
                    <tr>
                    <td class='itens'>" . $livro_data['CodLivro'] . "</td>"
                        . "<td class='itens'>" . $livro_data['nome'] . "</td>"
                        . "<td class='itens'>" . $livro_data['autor'] . "</td>"
                        . "<td class='itens'>" . $livro_data['editora'] . "</td>"
                        . "<td class='itens'>" . $lanca . "</td>"
                        . "<td class='itens'>" . $livro_data['quantidade'] . "</td>"
                        . "<td class='itens'>" . $livro_data['alugados'] . "</td>"
                        . "<td class='itens'>
                        <img src='img/pencil.png' data-id='$identifier' class='edit' onclick=" . "abrirModal('edit-modal')" . " alt='PencilEdit' title='Editar'>
                        &nbsp;&nbsp;
                        <img src='img/bin.png' data-id='$livro_data[CodLivro]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                    </td>
                    </tr>";
                }
                echo "</tbody></table>";
                ?>
                <!-- Área da paginação -->
                <div class="pagination <?php if (!empty($search)) {
                                            echo 'd-none';
                                        } ?>">
                    <!-- Guia da paginação -->
                    <ul class="pagination">
                        <li class="page-item <?php echo ($paginaAtual == 1) ? '' : ''; ?>">
                            <a class="page-link" href="livro.php?pagina=1" aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                        // Exibir link da página anterior, se existir
                        if ($paginaAtual > 4) {
                            echo "<li class='page-item'><a class='page-link' href='livro.php?pagina=1'>1</a></li>";
                        }
                        // Exibir páginas anteriores à página atual
                        if ($paginaAtual == $totalPaginas) {
                            for ($i = max(1, $paginaAtual - 2); $i < $paginaAtual; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='livro.php?pagina=$i'>$i</a></li>";
                            }
                        } else {
                            for ($i = max(1, $paginaAtual - 1); $i < $paginaAtual; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='livro.php?pagina=$i'>$i</a></li>";
                            }
                        }
                        // Exibir página atual
                        echo "<li class='page-item active'><span class='page-link'>$paginaAtual</span></li>";
                        // Exibir páginas posteriores à página atual
                        if ($paginaAtual == 1) {
                            for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 2, $totalPaginas); $i++) {
                                echo "<li class='page-item'><a class='page-link' href='livro.php?pagina=$i'>$i</a></li>";
                            }
                        } else {
                            for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 1, $totalPaginas); $i++) {
                                echo "<li class='page-item'><a class='page-link' href='livro.php?pagina=$i'>$i</a></li>";
                            }
                        }
                        ?>
                        <li class="page-item <?php echo ($paginaAtual == $totalPaginas) ? '' : ''; ?>">
                            <a class="page-link" href="livro.php?pagina=<?php echo $totalPaginas; ?>" aria-label="Próxima">
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
            // Faz a solicitação AJAX para obter os dados do banco de dados
            $.ajax({
                url: 'php/getdataBook.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Os dados são retornados como um array JSON
                    console.log(data)
                    $('.edit').click(function() {
                        var recordId = $(this).data('id');
                        x = recordId

                        var coluna1 = data[x].CodLivro;
                        var coluna2 = data[x].nome;
                        var coluna3 = data[x].autor;
                        var coluna4 = data[x].editora;
                        var coluna5 = data[x].lancamento;
                        var coluna6 = data[x].quantidade;

                        $('#campo1').val(coluna1);
                        $('#campo2').val(coluna2);
                        $('#campo3').val(coluna3);
                        $('#campo4').val(coluna4);
                        $('#campo5').val(coluna5);
                        $('#campo6').val(coluna6);
                    })
                    $('.exclu').click(function() {
                        var btnID = $(this).data('id')

                        $('.confirm_exclu').click(function() {
                            window.location.href = ".delete/delet-livro.php" + "?id=" + btnID;
                        })
                    })
                    // Aqui você pode manipular os dados como quiser,
                    // por exemplo, exibir na página ou realizar outras operações.
                },
                error: function(xhr, status, error) {
                    console.error('Erro na solicitação AJAX: ' + status + ' - ' + error);
                }
            });
        });
    </script>
</body>

</html>