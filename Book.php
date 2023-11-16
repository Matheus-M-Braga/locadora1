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
                        <h1 id="modalTitle" class="text-balck" style="font-size: 30px; margin-bottom: 5px;"></h1>
                        <img src="img/cross.png" alt="butão-fechar" class="fechar-modal" onclick="fecharModal('modal')">
                    </div>
                    <form id="form" action="" method="POST" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id" class="id">
                        <div class="col">
                            <div class="row-md-3">
                                <label for="nome" class="form-label text-black bold">Nome</label>
                                <input type="text" name="nome" id="nome" class="form-control nome" autocomplete="off" maxlength="45" required>
                                <div class="invalid-feedback">
                                    • Informe o nome
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="autor" class="form-label text-black">Autor</label>
                                <input type="text" name="autor" id="autor" class="form-control autor" autocomplete="off" maxlength="45" required>
                                <div class="invalid-feedback">
                                    • Informe o autor
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="select" class="form-label text-black">Editora</label>
                                <select name="editora" id="select" class="form-select needs-validation is-invalid" required>
                                </select>
                            </div>
                            <div class="row-md-3">
                                <label for="lancamento" class="form-label text-black">Lançamento</label>
                                <input type="text" name="lancamento" id="lancamento" class="form-control number lancamento" maxlength="4" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    • Informe o ano de lançamento
                                </div>
                            </div>
                            <div class="row-md-3">
                                <label for="quantidade" class="form-label text-black">Quantidade</label>
                                <input type="number" name="quantidade" id="quantidade" class="form-control number quantidade" maxlength="4" autocomplete="off" required>
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
                                        <img src='img/pencil.png' data-id='$livro_data[id]' class='edit' onclick=" . "abrirModal('modal'," . "'Editar');resetForm('modal');" . " alt='PencilEdit' title='Editar'>
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