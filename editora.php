<?php
session_start();

include_once('php/config.php');

// Insert
if (isset($_POST['submit'])) {

    include_once('php/config.php');

    $nomeEditora = $_POST['nome-editora'];
    $email = $_POST['email-editora'];
    $telefone = $_POST['telefone-editora'];
    $website = $_POST['site-editora'];

    $sqleditora = "SELECT * FROM editoras WHERE nome = '$nomeEditora'";
    $resultado = $conexao->query($sqleditora);

    if (mysqli_num_rows($resultado) == 1) {
        echo "<script>window.alert('Editora já cadastrada.')</script>";
    } else {
        $resultI = mysqli_query($conexao, "INSERT INTO editoras(nome, email, telefone, website) VALUES ('$nomeEditora', '$email', '$telefone', '$website')");
    }
}

// Teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: index.php');
}
$logado = $_SESSION['email'];

// Pesquisa
if (!empty($_GET['search'])) {
    $data = $_GET['search'];

    $sql = "SELECT * FROM editoras WHERE CodEditora LIKE '%$data%' OR nome LIKE '%$data%' OR email LIKE '%$data%' OR telefone LIKE '%$data%' ORDER BY CodEditora ASC";
} else {
    $sql = "SELECT * FROM editoras ORDER BY CodEditora ASC";
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
    $sqlsearch = "SELECT * FROM editoras WHERE CodEditora LIKE '%$data%' OR nome LIKE '%$data%' OR email LIKE '%$data%' OR telefone LIKE '%$data%' ORDER BY CodEditora ASC";
    $result = $conexao->query($sqlsearch);
} else {
    $sql = "SELECT * FROM editoras ORDER BY CodEditora ASC LIMIT $registrosPorPagina OFFSET $offset";
    $result = $conexao->query($sql);
}

// Ordem alfabética 
if (isset($_GET['name'])) {
    $sql = "SELECT * FROM editoras ORDER BY nome ASC LIMIT $registrosPorPagina";
    $result = $conexao->query($sql);

    if ($_GET['name'] == 1) {
        $sql = "SELECT * FROM editoras ORDER BY nome DESC LIMIT $registrosPorPagina";
        $result = $conexao->query($sql);
    }
}

// Ordem pelo id
if (isset($_GET['id'])) {


    $sql = "SELECT * FROM editoras ORDER BY CodEditora ASC LIMIT $registrosPorPagina";
    $result = $conexao->query($sql);

    if ($_GET['id'] == 1) {
        $sql = "SELECT * FROM editoras WHERE CodEditora > 5 ORDER BY CodEditora DESC LIMIT $registrosPorPagina";
        $result = $conexao->query($sql);
    }
}

$result = $conexao->query($sql);
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
    <script src="js/script.js"></script>
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
                    <a href="editora.php" class="selected">Editoras</a>
                </div>
                <div class="link">
                    <img src="img/alugueis.png" alt="" class="links_icons">
                    <a href="aluguel.php">Aluguéis</a>
                </div>
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
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastro da Editora</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </div>
                    <form action="editora.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <div class="input_row">
                                <div class="row-md-3">
                                    <label for="input1" class="form-label text-black bold">Nome</label>
                                    <input name="nome-editora" type="text" id="input1" class="form-control" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                                <div class="row-md-3">
                                    <label for="input2" class="form-label text-black">E-mail</label>
                                    <input name="email-editora" type="email" id="input2" class="form-control" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                            </div>
                            <div class="input_row">
                                <div class="row-md-3">
                                    <label for="input3" class="form-label text-black">Telefone</label>
                                    <input name="telefone-editora" type="tel" id="input3" class="form-control" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                                <div class="row-md-3">
                                    <label for="input4" class="form-label text-black">Site</label>
                                    <input name="site-editora" placeholder="*Facultativo*" type="text" id="input4" class="form-control date" autocomplete="off">
                                    <div class="valid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center;">
                                <button class="btn btn-success" type="submit" name="submit">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal edit -->
            <div id="edit-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Editar Editora</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('edit-modal')">
                    </div>
                    <form action=".saves/save-editora.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <div class="input_row">
                                <input type="hidden" name="id" id="campo1">
                                <div class="row-md-3">
                                    <label for="input1" class="form-label text-black bold">Nome</label>
                                    <input name="nome-editora" type="text" id="campo2" class="form-control" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                                <div class="row-md-3">
                                    <label for="input2" class="form-label text-black">E-mail</label>
                                    <input name="email-editora" type="email" id="campo3" class="form-control" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                            </div>
                            <div class="input_row">
                                <div class="row-md-3">
                                    <label for="input3" class="form-label text-black">Telefone</label>
                                    <input name="telefone-editora" type="tel" id="campo4" class="form-control" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                                <div class="row-md-3">
                                    <label for="input4" class="form-label text-black">Site</label>
                                    <input name="site-editora" placeholder="*Facultativo*" type="text" id="campo5" class="form-control date" autocomplete="off">
                                    <div class="valid-feedback">
                                        • Campo obrigatório •
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center;">
                                <button class="btn btn-success" type="submit" name="update">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal exclu -->
            <div id="exclu-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck titulo_modal">Excluir Editora</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('exclu-modal')">
                    </div>
                    <div class="iconDel">
                        <img src="img/aviso.png" alt="">
                    </div>
                    <p>Tem certeza que deseja excluir a editora selecionada?</p>
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
                    <span class="titulo-pg">Editoras</span>
                    <div class="novobtn" onclick="abrirModal('vis-modal')">NOVO +</div>
                </div>
                <form class="searchbox sbx-custom" id="search-editora">
                    <div role="search" class="sbx-custom__wrapper">
                        <input type="search" name="search" placeholder="Pesquisar..." autocomplete="off" class="sbx-custom__input" id="pesquisadora">
                        <button type="submit" class="sbx-custom__submit" onclick="searchData()">
                            <img src="img/search.png" alt="">
                        </button>
                    </div>
                </form>
            </div>
            <?php
            if (!empty($_GET['pagina'])) {
                $paginaAtual = $_GET['pagina'];
            }
            // Montagem da grid (complicado)
            $dados = "<table class='container-grid'>
            <thead>
                <tr>
                    <th class='titulos'>ID</th>
                    <th class='titulos'>NOME</th>
                    <th class='titulos'>EMAIL</th>
                    <th class='titulos'>TELEFONE</th>
                    <th class='titulos'>AÇÕES</th>
                </tr>
            </thead><tbody>";
            echo $dados;
            $identifier = -1;
            while ($editora_data = mysqli_fetch_assoc($result)) {
                $identifier++;
                echo "
                <tr>
                    <td class='itens'>" . $editora_data['CodEditora'] . "</td>"
                    . "<td class='itens'>" . $editora_data['nome'] . "</td>"
                    . "<td class='itens'>" . $editora_data['email'] . "</td>"
                    . "<td class='itens'>" . $editora_data['telefone'] . "</td>"
                    . "<td class='itens'>
                        <img src='img/pencil.png' data-id='$identifier' class='edit' onclick=" . "abrirModal('edit-modal')" . " alt='PencilEdit' title='Editar'>
                        &nbsp;&nbsp;
                        <img src='img/bin.png' data-id='$editora_data[CodEditora]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                    </td>
                </tr>";
            }
            echo "</tbody></table><br>";
            ?>
            <!-- Área da paginação -->
            <div class="pagination <?php if (!empty($search)) {
                                        echo 'd-none';
                                    } ?>">
                <!-- Guia da paginação-->
                <ul class="pagination">
                    <li class="page-item <?php echo ($paginaAtual == 1) ? '' : ''; ?>">
                        <a class="page-link" href="editora.php?pagina=1" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                    // Exibir link da página anterior, se existir
                    if ($paginaAtual > 4) {
                        echo "<li class='page-item'><a class='page-link' href='editora.php?pagina=1'>1</a></li>";
                    }
                    // Exibir páginas anteriores à página atual
                    if ($paginaAtual == $totalPaginas) {
                        for ($i = max(1, $paginaAtual - 2); $i < $paginaAtual; $i++) {
                            echo "<li class='page-item'><a class='page-link' href='editora.php?pagina=$i'>$i</a></li>";
                        }
                    } else {
                        for ($i = max(1, $paginaAtual - 1); $i < $paginaAtual; $i++) {
                            echo "<li class='page-item'><a class='page-link' href='editora.php?pagina=$i'>$i</a></li>";
                        }
                    }
                    // Exibir página atual
                    echo "<li class='page-item active'><span class='page-link'>$paginaAtual</span></li>";
                    // Exibir páginas posteriores à página atual
                    if ($paginaAtual == 1) {
                        for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 2, $totalPaginas); $i++) {
                            echo "<li class='page-item'><a class='page-link' href='editora.php?pagina=$i'>$i</a></li>";
                        }
                    } else {
                        for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 1, $totalPaginas); $i++) {
                            echo "<li class='page-item'><a class='page-link' href='editora.php?pagina=$i'>$i</a></li>";
                        }
                    }
                    ?>
                    <li class="page-item <?php echo ($paginaAtual == $totalPaginas) ? '' : ''; ?>">
                        <a class="page-link" href="editora.php?pagina=<?php echo $totalPaginas; ?>" aria-label="Próxima">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </main>
    </div>
    <!-- scritps -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Faz a solicitação AJAX para obter os dados do banco de dados
            $.ajax({
                url: 'php/getdataEdit.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Os dados são retornados como um array JSON
                    console.log(data)
                    $('.edit').click(function() {
                        var recordId = $(this).data('id');
                        x = recordId

                        var coluna1 = data[x].CodEditora;
                        var coluna2 = data[x].nome;
                        var coluna3 = data[x].email;
                        var coluna4 = data[x].telefone;
                        var coluna5 = data[x].website;

                        $("#campo1").val(coluna1);
                        $('#campo2').val(coluna2);
                        $('#campo3').val(coluna3);
                        $('#campo4').val(coluna4);
                        $('#campo5').val(coluna5);

                    })
                    $('.exclu').click(function() {
                        var btnID = $(this).data('id')

                        $('.confirm_exclu').click(function() {
                            window.location.href = ".delete/delet-editora.php" + "?id=" + btnID;
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