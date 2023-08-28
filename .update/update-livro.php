<!DOCTYPE html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="../css/mediaquery.css?<?php echo rand(1, 1000); ?>">
</head>

<body>
    <?php
    include_once('../php/config.php');

    if (isset($_POST['update'])) {

        $codLivro = $_POST['id'];
        $nomeLivro = $_POST['nome-livro'];
        $autor = $_POST['autor'];
        $editora = $_POST['editora'];
        $lancamento = $_POST['lancamento'];
        $quantidade = $_POST['quantidade'];

        $sqlUpdate = "UPDATE livros SET nome = '$nomeLivro', autor = '$autor', editora = '$editora', lancamento = '$lancamento', quantidade = '$quantidade' WHERE id = '$codLivro'";

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
        .then(() => {window.location.href = '../livro.php';})
        </script>";
    }
    ?>
</body>