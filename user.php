<?php
session_start();

include_once('./php/config.php');

// Teste da seção
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    echo "<script> window.location.href = 'index.php' </script>";
}

// Select inicial
$sql = "SELECT * FROM usuarios ORDER BY id ASC";
$result = $conexao->query($sql);
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
                        if (mysqli_num_rows($result) > 0) {
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
                        } else {
                            echo "<tr><td class='itens noresult' colspan='6'>Nenhum registro encontrado</td></tr>";
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