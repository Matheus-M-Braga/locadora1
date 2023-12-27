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

        $id = $_GET['id'];
        $result = mysqli_query($conexao, "SELECT * FROM livros WHERE id = $id");

        $sqlAluguelConect_result = mysqli_query($conexao, "SELECT * FROM alugueis WHERE livro_id = '$id' AND data_devolucao = '0000-00-00'");

        if (mysqli_num_rows($sqlAluguelConect_result) == 1) {
            echo "
            <script>
               Swal.fire({
                  title: 'Livro possui aluguéis ativos!',
                  text: '',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../Book.php';})
            </script>";
        } else {
            if (mysqli_num_rows($result) == 1) {
                mysqli_query($conexao, "DELETE FROM livros WHERE id = $id");
                echo "
                <script>
                Swal.fire({
                    title: 'Livro deletado com sucesso!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Book.php';})
                </script>";
            } else {
                echo "
                <script>
                Swal.fire({
                    title: 'Erro ao deletar livro!',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Book.php';})
                </script>";
            }
            mysqli_query($conexao, "ALTER TABLE livros AUTO_INCREMENT = 1");
        }
    }
    ?>
</body>