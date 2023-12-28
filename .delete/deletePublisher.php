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
        $result = mysqli_query($conexao, "SELECT * FROM editoras WHERE id = $id");

        $sqlLivro_conect_result = mysqli_query($conexao, "SELECT * FROM livros WHERE editora_id = '$id'");

        if (mysqli_num_rows($sqlLivro_conect_result) > 1) {
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
            if (mysqli_num_rows($result) == 1) {
                mysqli_query($conexao, "DELETE FROM editoras WHERE id = $id");
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
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Erro ao deletar editora!',
                        text: '',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1700
                    })
                    .then(() => {window.location.href = '../Publisher.php';})
                </script>";
            }
            mysqli_query($conexao, "ALTER TABLE editoras AUTO_INCREMENT = 1");
        }
    }
    ?>
</body>