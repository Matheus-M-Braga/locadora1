<?php
session_start();

include_once('php/config.php');

// Teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}

// Paginação/Pesquisa
$sql = "SELECT * FROM editoras ORDER BY id ASC";
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
    $sqlsearch = "SELECT * FROM editoras WHERE id LIKE '%$data%' OR nome LIKE '%$data%' OR email LIKE '%$data%' OR telefone LIKE '%$data%' ORDER BY id ASC";
    $result = $conexao->query($sqlsearch);
} else {
    $sql = "SELECT * FROM editoras ORDER BY id ASC LIMIT $registrosPorPagina OFFSET $offset";
    $result = $conexao->query($sql); 
}

// // Ordem alfabética 
// if (isset($_GET['name'])) {
//     $sql = "SELECT * FROM editoras ORDER BY nome ASC LIMIT $registrosPorPagina";
//     $result = $conexao->query($sql);

//     if ($_GET['name'] == 1) {
//         $sql = "SELECT * FROM editoras ORDER BY nome DESC LIMIT $registrosPorPagina";
//         $result = $conexao->query($sql);
//     }
// }

// // Ordem pelo id
// if (isset($_GET['id'])) {


//     $sql = "SELECT * FROM editoras ORDER BY id ASC LIMIT $registrosPorPagina";
//     $result = $conexao->query($sql);

//     if ($_GET['id'] == 1) {
//         $sql = "SELECT * FROM editoras WHERE id > 5 ORDER BY id DESC LIMIT $registrosPorPagina";
//         $result = $conexao->query($sql);
//     }
// }
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
        document.addEventListener("DOMContentLoaded", function() {
            var search = document.getElementById('pesquisadora');
            search.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    searchData();
                }
            });

            function searchData() {
                window.location = "editora.php?search=" + search.value;
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
            <div class="dropdown">
                <button onclick="toggleDropdown()">Menu</button>
                <ul class="dropdown-content" id="dropdownContent">
                    <li><a href="inicio.php">Dashboard</a></li>
                    <li><a href="user.php">Usuários</a></li>
                    <li><a href="livro.php">Livros</a></li>
                    <li><a href="editora.php" class="selected">Edtioras</a></li>
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
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastro da Editora</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </div>
                    <form action=".create/create-editora.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black bold">Nome</label>
                                <input name="nome-editora" type="text" id="input1" class="form-control" maxlength="45" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">E-mail</label>
                                <input name="email-editora" type="email" id="input2" class="form-control" maxlength="100" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o email
                                </div>
                            </div>

                            <div class="row-md-3">
                                <label for="input3" class="form-label text-black">Telefone</label>
                                <input name="telefone-editora" type="text" id="input3" class="form-control telefone" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o telefone
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
                    <form action=".update/update-editora.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <input type="hidden" name="id" id="campo1">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black bold">Nome</label>
                                <input name="nome-editora" type="text" id="campo2" class="form-control" maxlength="45" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">E-mail</label>
                                <input name="email-editora" type="email" id="campo3" class="form-control" maxlength="100" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o e-mail
                                </div>
                            </div>

                            <div class="row-md-3">
                                <label for="input3" class="form-label text-black">Telefone</label>
                                <input name="telefone-editora" type="text" id="campo4" class="form-control telefone" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o telefone
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
            <!-- GRID -->
            <div class="grid-header">
                <div class="wrapper">
                    <span class="titulo-pg">Editoras</span>
                    <div class="novobtn" onclick="abrirModal('vis-modal'); resetForm('vis-modal');">NOVO <span class="material-symbols-outlined">add</span></div>
                </div>
                <form class="searchbox sbx-custom" id="search-editora">
                    <div role="search" class="sbx-custom__wrapper">
                        <span class="material-symbols-outlined search">search</span>
                        <input type="search" name="search" placeholder="Pesquisar..." autocomplete="off" class="sbx-custom__input" id="pesquisadora">
                    </div>
                </form>
            </div>
            <div class="grid-body">
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
                if (mysqli_num_rows($result) > 0) {
                    while ($editora_data = mysqli_fetch_assoc($result)) {
                        echo "
                        <tr>
                            <td class='itens'>" . $editora_data['id'] . "</td>"
                                . "<td class='itens'>" . $editora_data['nome'] . "</td>"
                                . "<td class='itens'>" . $editora_data['email'] . "</td>"
                                . "<td class='itens'>" . $editora_data['telefone'] . "</td>"
                                . "<td class='itens'>
                                <img src='img/pencil.png' data-id='$editora_data[id]' class='edit' onclick=" . "abrirModal('edit-modal');resetForm('edit-modal');" . " alt='PencilEdit' title='Editar'>
                                &nbsp;&nbsp;
                                <img src='img/bin.png' data-id='$editora_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td class='itens noresult' colspan='5'>Nenhum registro encontrado</td></tr>";
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
            </div>
        </main>
    </div>
    <!-- scritps -->
    <script src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Consulta ajax
            $.ajax({
                url: 'php/getdataEdit.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('.edit').click(function() {
                        var recordId = $(this).data('id');
                        x = recordId

                        var coluna1 = data[x].id;
                        var coluna2 = data[x].nome;
                        var coluna3 = data[x].email;
                        var coluna4 = data[x].telefone;
                        var coluna5 = data[x].website;

                        $("#campo1").val(coluna1);
                        $('#campo2').val(coluna2);
                        $('#campo3').val(coluna3);
                        $('#campo4').val(coluna4);

                    })
                    $('.exclu').click(function() {
                        var btnID = $(this).data('id')

                        $('.confirm_exclu').click(function() {
                            window.location.href = ".delete/delet-editora.php" + "?id=" + btnID;
                        })
                    })
                },
                error: function(xhr, status, error) {
                    console.error('Erro na solicitação AJAX: ' + status + ' - ' + error);
                }
            });
            // Máscaras
            $('.telefone').mask('(00) 00000-0000');
        });
    </script>
</body>

</html>