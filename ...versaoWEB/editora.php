<?php
session_start();

include_once('php/config.php');

// Teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}

$sql = "SELECT * FROM editoras ORDER BY id ASC";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Strap -->
    <link rel="stylesheet" href="css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="css/mediaquery.css?<?php echo rand(1, 1000); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
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
                    <li><a href="editora.php" class="selected" id="pageTitle">Editoras</a></li>
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
                                <label for="input3" class="form-label text-black">Cidade</label>
                                <input name="cidade-editora" type="text" id="input3" class="form-control cidade" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o cidade
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
                            <input type="hidden" name="id" id="campo1" class="id">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black bold">Nome</label>
                                <input name="nome-editora" type="text" id="campo2" class="form-control nome" maxlength="45" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">E-mail</label>
                                <input name="email-editora" type="email" id="campo3" class="form-control email" maxlength="100" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o e-mail
                                </div>
                            </div>

                            <div class="row-md-3">
                                <label for="input3" class="form-label text-black">Cidade</label>
                                <input name="cidade-editora" type="text" id="campo4" class="form-control cidade" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe a cidade
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
            <div class="grid-body">
                <table class='container-grid' id="tabela">
                    <thead>
                        <tr>
                            <th class='titulos'>ID</th>
                            <th class='titulos'>NOME</th>
                            <th class='titulos'>CIDADE</th>
                            <th class='titulos'>EMAIL</th>
                            <th class='titulos'>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($editora_data = mysqli_fetch_assoc($result)) {
                                echo "
                        <tr>
                            <td class='itens'>" . $editora_data['id'] . "</td>"
                                    . "<td class='itens'>" . $editora_data['nome'] . "</td>"
                                    . "<td class='itens'>" . $editora_data['cidade'] . "</td>"
                                    . "<td class='itens'>" . $editora_data['email'] . "</td>"
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
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <!-- scritps -->
    <script type="module" src="js/module.js"></script>
    <script src="js/script.js"></script>
    <script src="js/jquery.mask.min.js"></script>
</body>
</html>