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
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastro da Editora</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </div>
                    <form action=".create/createPublisher.php" method="POST" class="row g-3 needs-validation" novalidate>
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
                    <form action=".update/updatePublisher.php" method="POST" class="row g-3 needs-validation" novalidate>
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
    <?php
    include("components/general/scripts.php");
    ?>
</body>

</html>