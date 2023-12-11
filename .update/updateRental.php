<!DOCTYPE html>

<head>
    <?php
    $pageTitle = "Atualizar Aluguel";
    include("../components/crud/head.php");
    ?>
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../php/config.php');

        date_default_timezone_set('America/Sao_Paulo');

        $id = $_GET['id'];
        $result = mysqli_query($conexao, "SELECT * FROM alugueis WHERE id = $id");
        $aluguel = mysqli_fetch_assoc($result);

        $hoje = date('Y-m-d');

        // Controle de estoque
        $selectLivro = mysqli_query($conexao, "SELECT * FROM livros WHERE id = " . $aluguel['livro_id'] . "");
        $livro = mysqli_fetch_assoc($selectLivro);
        $quantidade = $livro['quantidade'] + 1;
        $alugados = $livro['alugados'] - 1;
        mysqli_query($conexao, "UPDATE livros SET quantidade = '$quantidade', alugados = '$alugados' WHERE id = " . $livro['id'] . "");

        if ($result->num_rows > 0) {
            if ($hoje <= $aluguel['prev_devolucao']) {
                $status = "No prazo";
            } else if ($hoje > $aluguel['prev_devolucao']) {
                $status = "Atrasado";
            }
            mysqli_query($conexao, "UPDATE alugueis SET data_devolucao = '$hoje', status = '$status' WHERE id = $id");
            echo "
            <script>
               Swal.fire({
                  title: 'Devolução realizada com sucesso!',
                  text: '',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../Rental.php';})
            </script>";
        } else {
            echo "
            <script>
               Swal.fire({
                  title: 'Erro ao realizar devolução!',
                  text: '',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../Rental.php';})
            </script>";
        }
    }
    ?>
</body>