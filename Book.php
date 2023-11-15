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
                        <h1 class="text-balck" style="font-size: 30px; margin-bottom: 5px;">Cadastro do Livro</h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('vis-modal')">
                    </div>
                    <form action=".create/createBook.php" method="POST" class="row g-3 needs-validation" novalidate>
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
                    <form action=".update/updateBook.php" method="POST" class="row g-3 needs-validation" novalidate>
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
    <?php
    include("components/general/scripts.php");
    ?>
</body>

</html>