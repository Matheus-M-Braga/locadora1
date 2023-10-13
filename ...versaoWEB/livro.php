<?php
session_start();

include_once('php/config.php');

// Teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}

$sql = "SELECT * FROM livros ORDER BY id ASC";
$result = $conexao->query($sql);

// Conexão tabela editoras
$sqlEditoras_conect = "SELECT * FROM editoras ORDER BY id ASC";
$resultEditora_conect = $conexao->query($sqlEditoras_conect);
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="css/mediaquery.css?<?php echo rand(1, 1000); ?>">
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
                    <li><a href="livro.php" class="selected" id="pageTitle">Livros</a></li>
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
                                <input name="nome-livro" type="text" class="form-control" id="input1" maxlength="45" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">Autor</label>
                                <input name="autor" type="text" class="form-control" id="input2" maxlength="45" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o autor
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
                            <div class="row-md-3">
                                <label for="input4" class="form-label text-black">Lançamento</label>
                                <input name="lancamento" type="text" class="form-control number" id="input4" maxlength="4" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe o ano de lançamento
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input5" class="form-label text-black">Quantidade</label>
                                <input name="quantidade" type="number" class="form-control number" id="input5" maxlength="4" required autocomplete="off">
                                <div class="invalid-feedback">
                                    • Informe a quantidade
                                </div>
                            </div>
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
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('edit-modal');">
                    </div>
                    <form action=".update/update-livro.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id" class="id">
                        <div class="row-md-3">
                            <label for="campo2" class="form-label text-black bold">Nome</label>
                            <input name="nome-livro" type="text" class="form-control nome" id="campo2" maxlength="45" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Informe o nome
                            </div>
                        </div>
                        <div class="row-md-3">
                            <label for="campo3" class="form-label text-black">Autor</label>
                            <input name="autor" type="text" class="form-control autor" class="autor" id="campo3" maxlength="45" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Informe o autor
                            </div>
                        </div>
                        <div class="row-md-3">
                            <label for="campo4" class="form-label text-black">Editora</label>
                            <select title="fodase" name="editora" class="form-select needs-validation is-valid" id="select" required>
                            <option value="" class="editora" id="selected" selected></option>
                            </select>
                        </div>
                        <div class="row-md-3">
                            <label for="campo5" class="form-label text-black">Lançamento</label>
                            <input name="lancamento" type="text" class="form-control number lancamento" id="campo5" maxlength="4" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Informe o ano de lançamento
                            </div>
                        </div>
                        <div class="row-md-3">
                            <label for="campo6" class="form-label text-black">Quantidade</label>
                            <input name="quantidade" type="number" class="form-control number quantidade" id="campo6" maxlength="4" required autocomplete="off">
                            <div class="invalid-feedback">
                                • Informe a quantidade
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
            <!-- GRID -->
            <div class="grid-body">
                <table class="container-grid" id="tabela">
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
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($livro_data = mysqli_fetch_assoc($result)) {
                                // Conexão tabela alugueis
                                $nome_livro = $livro_data['nome'];
                                $id = $livro_data['id'];
                                $sqlAluguelConect = "SELECT * FROM alugueis WHERE livro = '$nome_livro' AND data_devolucao = 0";
                                $sqlAluguelResult = $conexao->query($sqlAluguelConect);
                                $livro_data['alugados'] = $sqlAluguelResult->num_rows;
                                $aluguel_quant = $livro_data['alugados'];

                                mysqli_query($conexao, "UPDATE livros SET alugados = '$aluguel_quant' WHERE id = '$id' ");
                                echo "
                                <tr>
                                    <td class='itens'>" . $livro_data['id'] . "</td>"
                                    . "<td class='itens'>" . $livro_data['nome'] . "</td>"
                                    . "<td class='itens'>" . $livro_data['autor'] . "</td>"
                                    . "<td class='itens'>" . $livro_data['editora'] . "</td>"
                                    . "<td class='itens'>" . $livro_data['lancamento'] . "</td>"
                                    . "<td class='itens'>" . $livro_data['quantidade'] . "</td>"
                                    . "<td class='itens'>" . $livro_data['alugados'] . "</td>"
                                    . "<td class='itens'>
                                        <img src='img/pencil.png' data-id='$livro_data[id]' class='edit' onclick=" . "abrirModal('edit-modal');resetForm('edit-modal');" . " alt='PencilEdit' title='Editar'>
                                        &nbsp;&nbsp;
                                        <img src='img/bin.png' data-id='$livro_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td class='itens noresult' colspan='8'>Nenhum registro encontrado</td></tr>";
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