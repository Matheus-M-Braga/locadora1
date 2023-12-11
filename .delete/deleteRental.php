<!DOCTYPE html>

<head>
    <?php
    $pageTitle = "Excluir Aluguel";
    include("../components/crud/head.php");
    ?>
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../php/config.php');

        $id = $_GET['id'];
        $result = mysqli_query($conexao, "SELECT * FROM alugueis WHERE id = $id");
        $aluguel = mysqli_fetch_assoc($result);

        // Controle de estoque
        $selectLivro = mysqli_query($conexao, "SELECT * FROM livros WHERE id = " . $aluguel['livro_id'] . "");
        $livro = mysqli_fetch_assoc($selectLivro);
        $quantidade = $livro['quantidade'] + 1;
        $alugados = $livro['alugados'] - 1;
        mysqli_query($conexao, "UPDATE livros SET quantidade = '$quantidade', alugados = '$alugados' WHERE id = " . $livro['id'] . "");

        if ($result->num_rows > 0) {
            mysqli_query($conexao, "DELETE FROM alugueis WHERE id = $id");
            echo "
            <script>
                Swal.fire({
                    title: 'Aluguel deletado com sucesso!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Rental.php';})
            </script>";

            mysqli_query($conexao, "ALTER TABLE alugueis AUTO_INCREMENT = 1");
        } else {
            echo "
            <script>
                Swal.fire({
                    title: 'Erro ao deletar aluguel!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Rental.php';})
            </script>";
        }
    }
    ?>
</body>