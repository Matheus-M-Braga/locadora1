<?php
session_start();

include_once('./php/config.php');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}

$result = mysqli_query($conexao, "SELECT * FROM usuarios ORDER BY id ASC");
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
                    <a href="Home.php" class="">Dashboard</a>
                </div>
                <div class="link">
                    <img src="img/usuarios.png" alt="" class="links_icons">
                    <a href="User.php" class="selected">Usuários</a>
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
                    <li><a href="Home.php" class="">Dashboard</a></li>
                    <li><a href="User.php" class="selected" id="pageTitle">Usuários</a></li>
                    <li><a href="Book.php" class="" id="">Livros</a></li>
                    <li><a href="Publisher.php" class="" id="">Editoras</a></li>
                    <li><a href="Rental.php" class="" id="">Aluguéis</a></li>
                </ul>
            </div>
            <a href="php/logout.php" id="sair-btn"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
        </nav>
    </header>
    <div class="corpo">
        <main>
            <div id="modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 id="modalTitle" class="text-balck titulo_modal"></h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('modal')">
                    </div>
                    <form id="form" action="" method="POST" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id" class="id">
                        <div class="col">
                            <div class="row-md-3">
                                <label for="nome" class="form-label text-black">Nome</label>
                                <input type="text" name="nome" id="nome" class="form-control nome" autocomplete="off" maxlength="45" required>
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="cidade" class="form-label text-black">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control cidade" autocomplete="off" maxlength="45" required>
                                <div class="invalid-feedback">
                                    • Informe a cidade
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="endereco" class="form-label text-black">Endereço</label>
                                <input type="text" name="endereco" id="endereco" class="form-control endereco" autocomplete="off" maxlength="75" required>
                                <div class="invalid-feedback">
                                    • Informe o endereço
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="email" class="form-label text-black">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control email" autocomplete="off" maxlength="100" required>
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
            <div class="grid-body">
                <table class='container-grid ' id="tabela">
                    <thead>
                        <tr>
                            <th class='titulos' id='id'>ID</th>
                            <th class='titulos' id='nome'>NOME</th>
                            <th class='titulos' id='cidade'>CIDADE</th>
                            <th class='titulos' id='endereco'>ENDEREÇO</th>
                            <th class='titulos' id='mail'>EMAIL</th>
                            <th class='titulos acoes'>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($user_data = mysqli_fetch_assoc($result)) {
                            echo "
                                <tr>
                                <td class='itens ID'>" . $user_data['id'] . "</td>"
                                . "<td class='itens'>" . $user_data['nome'] . "</td>"
                                . "<td class='itens'>" . $user_data['cidade'] . "</td>"
                                . "<td class='itens'>" . $user_data['endereco'] . "</td>"
                                . "<td class='itens'>" . $user_data['email'] . "</td>"
                                . "<td class='itens'>
                                    <img src='img/pencil.png' data-id='$user_data[id]' class='edit' onclick=" . "abrirModal('modal'," . "'Editar');resetForm('modal');" . " alt='PencilEdit' title='Editar'>
                                    &nbsp;&nbsp;
                                    <img src='img/bin.png' data-id='$user_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal'," . "'Excluir')" . " alt='Bin' title='Deletar'>
                                </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script type="module" src="js/module.js"></script>
    <script src="js/script.js"></script>
</body>

</html>