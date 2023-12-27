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
    if (isset($_POST['submit'])) {
        include_once('../php/config.php');

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $autor = $_POST['autor'];
        $editora = $_POST['editora'];
        $lancamento = $_POST['lancamento'];
        $quantidade = $_POST['quantidade'];

        $result = mysqli_query($conexao, "SELECT * FROM livros WHERE id = $id");

        if (mysqli_num_rows($result) == 1) {
            mysqli_query($conexao, "UPDATE livros SET nome = '$nome', autor = '$autor', editora = '$editora', lancamento = '$lancamento', quantidade = '$quantidade' WHERE id = '$id'");

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
            echo "
            <script>
                Swal.fire({
                    title: 'Erro ao atualizar livro!',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1700
                })
            .then(() => {window.location.href = '../Book.php';})
            </script>";
        }
    }
    ?>
</body>