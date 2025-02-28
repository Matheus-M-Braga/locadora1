<?php
session_start();
include_once('php/config.php');
date_default_timezone_set('America/Sao_Paulo');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}

$result = mysqli_query($conexao, "SELECT * FROM alugueis");
$resultLivro_conect = mysqli_query($conexao, "SELECT * FROM livros ORDER BY id ASC");
$resultUsuario_conect = mysqli_query($conexao, "SELECT * FROM usuarios ORDER BY id ASC");

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
                    <a href="User.php" class="">Usuários</a>
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
                    <a href="Rental.php" class="selected">Aluguéis</a>
                </div>
            </div>
            <div class="dropdown">
                <button onclick="toggleDropdown()">Menu</button>
                <ul class="dropdown-content" id="dropdownContent">
                    <li><a href="Home.php" class="">Dashboard</a></li>
                    <li><a href="User.php" class="" id="">Usuários</a></li>
                    <li><a href="Book.php" class="" id="">Livros</a></li>
                    <li><a href="Publisher.php" class="" id="">Editoras</a></li>
                    <li><a href="Rental.php" class="selected" id="pageTitle">Aluguéis</a></li>
                </ul>
            </div>
            <a href="php/logout.php" id="sair-btn"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
        </nav>
    </header>
    <div class="corpo">
        <main>
            <div id="modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <class class="top_modal">
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastrar Aluguel</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('modal')">
                    </class>
                    <form id="form" action=".create/createRental.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black">Livro</label>
                                <select name="livro" class="form-control form-select needs-validation is-invalid" id="input1" required>
                                    <option value="" selected disabled>Selecione:</option>
                                    <?php
                                    while ($livro_data = mysqli_fetch_assoc($resultLivro_conect)) {
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
                                    while ($user_data = mysqli_fetch_assoc($resultUsuario_conect)) {
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
            <div class="grid-body">
                <table class='container-grid' id='tabela'>
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
                    </thead>
                    <tbody>
                        <?php
                        while ($aluguel_data = mysqli_fetch_assoc($result)) {
                            // Conversão dd/MM/yyyy
                            $alug_dat = date("d/m/Y", strtotime($aluguel_data['data_aluguel']));
                            $prev_dat = date("d/m/Y", strtotime($aluguel_data['prev_devolucao']));
                            $dev_dat = date("d/m/Y", strtotime($aluguel_data['data_devolucao']));

                            // Select na tabela de livros com base no 'livro_id'
                            $resultLivro = mysqli_query($conexao, "SELECT nome FROM livros WHERE id = " . $aluguel_data['livro_id'] . " ");
                            $livro_data = mysqli_fetch_assoc($resultLivro);

                            // Select na tabela de usuarios com base no 'usuario_id'
                            $resultUsuario = mysqli_query($conexao, "SELECT nome FROM usuarios WHERE id = " . $aluguel_data['usuario_id'] . " ");
                            $usuario_data = mysqli_fetch_assoc($resultUsuario);

                            echo "
                                <tr>
                                <td class='itens'>" . $aluguel_data['id'] . "</td>"
                                . "<td class='itens'>" . $livro_data['nome'] . "</td>"
                                . "<td class='itens'>" . $usuario_data['nome'] . "</td>"
                                . "<td class='itens'>" . $alug_dat . "</td>"
                                . "<td class='itens'>" . $prev_dat . "</td>";

                            if ($aluguel_data['data_devolucao'] === "0000-00-00") {
                                echo "<td class='itens'>...</td>"
                                    . "<td class='itens'>" . $aluguel_data['status'] . "</td>";
                                echo "<td class='itens'>
                                    <img src='img/check.png' alt='Devolver' title='Devolver' data-id='$aluguel_data[id]'  class='devol' onclick=" . "abrirModal('devol-modal')" . ">
                                    <img src='img/bin.png' data-id='$aluguel_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                                    </td></tr>";
                            } else {
                                $hoje = date("Y/m/d");
                                $previsao = $aluguel_data['prev_devolucao'];
                                echo "<td class='itens'>" . $dev_dat . "</td>"
                                    . "<td class='itens'>" . $aluguel_data['status'] . "</td>";
                                echo "<td class='itens'> </td></tr>";
                            }
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