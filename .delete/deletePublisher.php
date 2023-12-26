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

        $sqlSelect = "SELECT * FROM editoras WHERE id = $id";

        $result = $conexao->query($sqlSelect);

        $editora_data = mysqli_fetch_assoc($result);
        $nome = $editora_data['nome'];

        // Conexão tabela livros
        $sqlLivro_conect = "SELECT * FROM livros WHERE editora = '$nome'";
        $sqlLivro_conect_result = $conexao->query($sqlLivro_conect);

        while ($livro_data = mysqli_fetch_assoc($sqlLivro_conect_result)) {
            $livrosAssociados[] = $livro_data;
        }

        if ($livrosAssociados != null) {
            echo "
            <script>
                Swal.fire({
                    title: 'Editora possui livros cadastrados!',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Publisher.php';})
            </script>";
        } else {
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM editoras WHERE id = $id";
                $resultDelete = $conexao->query($sqlDelete);
            }
            $sqlReset = "ALTER TABLE editoras AUTO_INCREMENT = 1;";
            $resultReset = $conexao->query($sqlReset);
            echo "
            <script>
                Swal.fire({
                    title: 'Editora deletada com sucesso!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Publisher.php';})
            </script>";
        }
    }
    ?>
</body>