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

        $codEditora = $_GET['id'];

        $sqlSelect = "SELECT * FROM editoras WHERE id = $codEditora";

        $result = $conexao->query($sqlSelect);

        $editora_data = mysqli_fetch_assoc($result);
        $nomeEditora = $editora_data['nome'];

        // Conexão tabela livros
        $sqlLivro_conect = "SELECT * FROM livros WHERE editora = '$nomeEditora'";
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
                .then(() => {window.location.href = '../editora.php';})
            </script>";
        } else {
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM editoras WHERE CodEditora = $codEditora";
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
                .then(() => {window.location.href = '../editora.php';})
            </script>";
        }
    }
    ?>
</body>