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

$sql = "SELECT * FROM alugueis ORDER BY status DESC";
$result = $conexao->query($sql);

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
    <?php
    include("components/general/head.php");
    ?>
</head>

<body>
    <?php
    include("components/general/header.php");
    ?>
    <div class="corpo">
        <main>
            <!-- modal -->
            <div id="vis-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <class class="top_modal">
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastro do Aluguel</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </class>
                    <form action=".create/createRental.php" method="POST" class="row g-3 needs-validation" novalidate>
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
                        if (mysqli_num_rows($result) > 0) {
                            while ($aluguel_data = mysqli_fetch_assoc($result)) {
                                // Datas para serem exibidas no padrão d/m/Y na tabela
                                $alug_dat = date("d/m/Y", strtotime($aluguel_data['data_aluguel']));
                                $prev_dat = date("d/m/Y", strtotime($aluguel_data['prev_devolucao']));
                                $dev_dat = date("d/m/Y", strtotime($aluguel_data['data_devolucao']));

                                echo "
                                <tr>
                                <td class='itens'>" . $aluguel_data['id'] . "</td>"
                                    . "<td class='itens'>" . $aluguel_data['livro'] . "</td>"
                                    . "<td class='itens'>" . $aluguel_data['usuario'] . "</td>"
                                    . "<td class='itens'>" . $alug_dat . "</td>"
                                    . "<td class='itens'>" . $prev_dat . "</td>";

                                if ($aluguel_data['data_devolucao'] == 0) {
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
                                    echo "<td class='itens'></td></tr>";
                                    //  <img src='img/bin.png' data-id='$aluguel_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
                                }
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
    <?php
    include("components/general/scripts.php");
    ?>
</body>

</html>