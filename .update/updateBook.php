<!DOCTYPE html>

<head>
    <?php
    $pageTitle = "Atualizar Livro";
    include("../components/crud/head.php");
    ?>
</head>

<body>
    <?php
    include_once('../php/config.php');

    if (isset($_POST['submit'])) {

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $autor = $_POST['autor'];
        $editora = $_POST['editora'];
        $lancamento = $_POST['lancamento'];
        $quantidade = $_POST['quantidade'];

        // Conexão tabela aluguéis
        $sql_livro = "SELECT * FROM livros WHERE id = $id";
        $result_livro = $conexao->query($sql_livro);
        $livro_data = mysqli_fetch_assoc($result_livro);
        $nome_old = $livro_data['nome'];

        $sql_aluguel = "SELECT * FROM alugueis WHERE livro = '$nome_old' AND data_devolucao = 0";
        $result_aluguel = $conexao->query($sql_aluguel);

        if ($result_aluguel->num_rows > 0) {
            $UpdateLivroName = "UPDATE alugueis SET livro = '$nome' WHERE livro = '$nome_old'";
            $result = $conexao->query($UpdateLivroName);

            $sqlUpdate = "UPDATE livros SET nome = '$nome', autor = '$autor', editora = '$editora', lancamento = '$lancamento', quantidade = '$quantidade' WHERE id = '$id'";
            $result = $conexao->query($sqlUpdate);

            echo "
            <script>
                Swal.fire({
                    title: 'Livro atualizado com sucesso!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1700
                })
            .then(() => {window.location.href = '../Book.php';})
            </script>";
        } else {
            $sqlUpdate = "UPDATE livros SET nome = '$nome', autor = '$autor', editora = '$editora', lancamento = '$lancamento', quantidade = '$quantidade' WHERE id = '$id'";
            $result = $conexao->query($sqlUpdate);

            echo "
            <script>
                Swal.fire({
                    title: 'Livro atualizado com sucesso!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1700
                })
            .then(() => {window.location.href = '../Book.php';})
            </script>";
        }
    }
    ?>
</body>