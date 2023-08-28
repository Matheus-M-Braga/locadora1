<!DOCTYPE html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="../css/mediaquery.css?<?php echo rand(1, 1000); ?>">
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../php/config.php');

        date_default_timezone_set('America/Sao_Paulo');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM alugueis WHERE id = $id";
        $resultSelect = $conexao->query($sqlSelect);

        $aluguel_data = mysqli_fetch_assoc($resultSelect);
        $livro = $aluguel_data['livro'];

        $hoje = date('Y-m-d');


        // Conexão tabela Livros
        $sqllivro_conect = "SELECT * FROM livros WHERE nome = '$livro'";
        $resultlivro_conect = $conexao->query($sqllivro_conect);

        $livro_data = mysqli_fetch_assoc($resultlivro_conect);
        $nomeLivro_BD = $livro_data['nome'];
        $quantidade_BD = $livro_data['quantidade'];
        $quantidade_nova = $quantidade_BD + 1;

        $sqlAlterar = "UPDATE livros SET quantidade = '$quantidade_nova' WHERE nome = '$nomeLivro_BD'";
        $sqlResultAlterar = $conexao->query($sqlAlterar);

        if ($resultSelect->num_rows > 0) {
            $sqlUpdate = "UPDATE alugueis SET data_devolucao = '$hoje' WHERE id = $id";
            $resultUpdate = $conexao->query($sqlUpdate);
            echo "
            <script>
               Swal.fire({
                  title: 'Devolução realizada com sucesso!',
                  text: '',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../aluguel.php';})
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
               .then(() => {window.location.href = '../aluguel.php';})
            </script>";
        }
    }
    ?>
</body>