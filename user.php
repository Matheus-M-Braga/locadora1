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
            <!-- Modal -->
            <div id="vis-modal" class="modal" style="font-family: 'Source Sans Pro',sans-serif;">
                <div class="conteudo-modal">
                    <div class="top_modal">
                        <h1 class="text-balck titulo_modal">Cadastro do Usuário</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </div>
                    <form action=".create/createUser.php" method="POST" class="row g-3 needs-validation" novalidate>
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
                    <form action=".update/updateUser.php" method="POST" class="row g-3 needs-validation" novalidate>
                        <div class="col">
                            <input type="hidden" class="id" id="id" name="id">
                            <div class="row-md-3">
                                <label for="input1" class="form-label text-black bold">Nome</label>
                                <input name="nome-user" type="text" id="nome" class="form-control nome" maxlength="45" required autocomplete="off" value="">
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input2" class="form-label text-black">Cidade</label>
                                <input name="cidade" type="text" id="cidade" class="form-control cidade" maxlength="45" required autocomplete="off" value="">
                                <div class="invalid-feedback">
                                    • Informe a cidade
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="input3" class="form-label text-black">Endereço</label>
                                <input name="endereco" type="text" id="endereco" class="form-control endereco" maxlength="75" required autocomplete="off" value="">
                                <div class="invalid-feedback">
                                    • Informe o endereço
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="validationCustom02" class="form-label text-black">E-mail</label>
                                <input name="email" type="email" id="email" class="form-control email date" maxlength="100" required autocomplete="off" value="">
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
                                    <img src='img/pencil.png' data-id='$user_data[id]' class='edit' onclick=" . "abrirModal('edit-modal');resetForm('edit-modal');" . " alt='PencilEdit' title='Editar'>
                                    &nbsp;&nbsp;
                                    <img src='img/bin.png' data-id='$user_data[id]' class='exclu' onclick=" . "abrirModal('exclu-modal')" . " alt='Bin' title='Deletar'>
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