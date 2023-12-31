<!DOCTYPE html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css" media="all">
    <link rel="stylesheet" href="../css/mediaquery.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>WDA Livraria</title>
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../php/config.php');
        date_default_timezone_set('America/Sao_Paulo');

        $id = $_GET['id'];
        $result = mysqli_query($conexao, "SELECT * FROM alugueis WHERE id = $id");
        $aluguel = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            $hoje = date('Y-m-d');

            $selectLivro = mysqli_query($conexao, "SELECT * FROM livros WHERE id = " . $aluguel['livro_id'] . "");
            $livro = mysqli_fetch_assoc($selectLivro);
            $quantidade = $livro['quantidade'] + 1;
            $alugados = $livro['alugados'] - 1;
            mysqli_query($conexao, "UPDATE livros SET quantidade = '$quantidade', alugados = '$alugados' WHERE id = " . $livro['id'] . "");

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