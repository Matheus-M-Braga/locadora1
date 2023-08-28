<?php
session_start();

include_once('./php/config.php');

// Teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}

// Paginaçã0/Pesquisa
$sql = "SELECT * FROM usuarios ORDER BY id ASC";
$registrosPorPagina = 5;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $registrosPorPagina;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$data = $search;

// Select com os parâmetros
$result = $conexao->query($sql);
$totalRegistros = $result->num_rows;
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
if (!empty($search)) {
    $sqlsearch = "SELECT * FROM usuarios WHERE id LIKE '%$data%' OR nome LIKE '%$data%' OR cidade LIKE '%$data%' OR email LIKE '%$data%' OR endereco LIKE '%$data%' ORDER BY id ASC";
    $result = $conexao->query($sqlsearch);
} else {
    $sql = "SELECT * FROM usuarios ORDER BY id ASC LIMIT $registrosPorPagina OFFSET $offset";
    $result = $conexao->query($sql);
}
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
    <link rel="stylesheet" href="css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="css/mediaquery.css?<?php echo rand(1, 1000); ?>">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var search = document.getElementById('pesquisadora');
            search.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    searchData();
                }
            });

            function searchData() {
                window.location = "user.php?search=" + search.value;
            }
        });
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
                    <a href="user.php" class="selected">Usuários</a>
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
                    <li><a href="inicio.php">Dashboard</a></li>
                    <li><a href="user.php" class="selected">Usuários</a></li>
                    <li><a href="livro.php">Livros</a></li>
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
                        <h1 class="text-balck titulo_modal">Cadastro do Usuário</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </div>
                    <form action=".create/create-user.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black bold">Nome</label>
                                <input name="nome-user" type="text" id="input1" class="form-control" maxlength="45" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">Cidade</label>
                                <input name="cidade" type="text" id="input2" class="form-control cidade" maxlength="45" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe a cidade
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input3" class="form-label text-black">Endereço</label>
                                <input name="endereco" type="text" id="input3" class="form-control endereco" maxlength="75" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o endereço
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="email" class="form-label text-black">E-mail</label>
                                <input name="email" type="email" id="email" class="form-control" maxlength="100" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o email
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center;">
                                <button class="btn btn-success" type="submit" name="submit">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal Edit -->
            <div id="edit-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck titulo_modal">Editar Usuário</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('edit-modal');">
                    </div>
                    <form action=".update/update-user.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <input type="hidden" id="campo1" name="id">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black bold">Nome</label>
                                <input name="nome-user" type="text" id="campo2" class="form-control" maxlength="45" required autocomplete="off" value="">
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">Cidade</label>
                                <input name="cidade" type="text" id="campo3" class="form-control cidade" maxlength="45" required autocomplete="off" value="">
                                <div class="invalid-feedback">
                                    • Informe a cidade
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input3" class="form-label text-black">Endereço</label>
                                <input name="endereco" type="text" id="campo4" class="form-control endereco" maxlength="75" required autocomplete="off" value="">
                                <div class="invalid-feedback">
                                    • Informe o endereço
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="validationCustom02" class="form-label text-black">E-mail</label>
                                <input name="email" type="email" id="campo5" class="form-control date" maxlength="100" required autocomplete="off" value="">
                                <div class="invalid-feedback">
                                    • Informe o email
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center;">
                                <button class="btn btn-success" type="submit" name="update">Confirmar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal exclu -->
            <div id="exclu-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck titulo_modal">Excluir Usuário</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('exclu-modal')">
                    </div>
                    <div class="iconDel">
                        <img src="img/aviso.png" alt="">
                    </div>
                    <p>Tem certeza que deseja excluir o usuário selecionado?</p>
                    <div class="col-12" style="text-align: center;">
                        <button class="btn btn-success" type="reset" onclick="fecharModal('exclu-modal')">Cancelar</button>
                        <button class="btn btn-danger confirm_exclu" type="submit" name="delete" id="excluir">Excluir</button>
                    </div>
                </div>
            </div>
            <!-- GRID -->
            <div class="grid-header">
                <div class="wrapper">
                    <span class="titulo-pg">Usuários</span>
                    <div class="novobtn" onclick="abrirModal('vis-modal'); resetForm('vis-modal');">NOVO <span class="material-symbols-outlined">add</span></div>
                </div>
                <form class="searchbox sbx-custom" id="search-user">
                    <div role="search" class="sbx-custom__wrapper">
                        <span class="material-symbols-outlined search">search</span>
                        <input type="search" name="search" placeholder="Pesquisar..." autocomplete="off" class="sbx-custom__input" id="pesquisadora">
                    </div>
                </form>
            </div>
            <!-- Tag responsável por exibir a listagem da página list -->
            <div class="grid-body">
                <?php
                $dados = "
                <table class='container-grid'>
                <thead>
                    <tr>
                        <th class='titulos'>ID</th>
                        <th class='titulos'>NOME</th>
                        <th class='titulos'>CIDADE</th>
                        <th class='titulos'>ENDEREÇO</th>
                        <th class='titulos'>EMAIL</th>
                        <th class='titulos'>AÇÕES</th>
                    </tr>
                </thead><tbody>";
                echo $dados;
                if (mysqli_num_rows($result) > 0) {
                    while ($user_data = mysqli_fetch_assoc($result)) {
                        echo "
                        <tr>
                        <td class='itens'>" . $user_data['id'] . "</td>"
                            . "<td class='itens'>" . $user_data['nome'] . "</td>"
                            . "<td class='itens'>" . $user_data['cidade'] . "</td>"
                            . "<td class='itens'>" . $user_data['endereco'] . "</td>"
                            . "<td class='itens'>" . $user_data['email'] . "</td>"
                            . "<td class='itens'>
                            <img src='img/pencil.png' data-id='$user_data[id]' class='edit' onclick=" . "abrirModal('edit-modal');resetForm('edit-modal');" . " alt='PencilEdit' title='Editar'>
                            &nbsp;&nbsp;
                            <img src='img/bin.png' data-id='$user_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                        </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td class='itens noresult' colspan='6'>Nenhum registro encontrado</td></tr>";
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
                            <a class="page-link" href="user.php?pagina=1" aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                        // Exibir link da página anterior, se existir
                        if ($paginaAtual > 4) {
                            echo "<li class='page-item'><a class='page-link' href='user.php?pagina=1'>1</a></li>";
                        }
                        // Exibir páginas anteriores à página atual
                        if ($paginaAtual == $totalPaginas) {
                            for ($i = max(1, $paginaAtual - 2); $i < $paginaAtual; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='user.php?pagina=$i'>$i</a></li>";
                            }
                        } else {
                            for ($i = max(1, $paginaAtual - 1); $i < $paginaAtual; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='user.php?pagina=$i'>$i</a></li>";
                            }
                        }
                        // Exibir página atual
                        echo "<li class='page-item active'><span class='page-link'>$paginaAtual</span></li>";
                        // Exibir páginas posteriores à página atual
                        if ($paginaAtual == 1) {
                            for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 2, $totalPaginas); $i++) {
                                echo "<li class='page-item'><a class='page-link' href='user.php?pagina=$i'>$i</a></li>";
                            }
                        } else {
                            for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 1, $totalPaginas); $i++) {
                                echo "<li class='page-item'><a class='page-link' href='user.php?pagina=$i'>$i</a></li>";
                            }
                        }
                        ?>
                        <li class="page-item <?php echo ($paginaAtual == $totalPaginas) ? '' : ''; ?>">
                            <a class="page-link" href="user.php?pagina=<?php echo $totalPaginas; ?>" aria-label="Próxima">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    <!-- scritps -->
    <script src="js/script.js"></script>
    <!-- Consulta ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'php/getdataUser.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('.edit').click(function() {
                        var recordId = $(this).data('id');
                        x = recordId

                        var coluna1 = data[x].id;
                        var coluna2 = data[x].nome;
                        var coluna3 = data[x].cidade;
                        var coluna4 = data[x].endereco;
                        var coluna5 = data[x].email;

                        $("#campo1").val(coluna1);
                        $('#campo2').val(coluna2);
                        $('#campo3').val(coluna3);
                        $('#campo4').val(coluna4);
                        $('#campo5').val(coluna5);
                    })
                    $('.exclu').click(function() {
                        var btnID = $(this).data('id')
                        $('.confirm_exclu').click(function() {
                            window.location.href = ".delete/delet-user.php" + "?id=" + btnID;
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