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
        $email = $_POST['email'];
        $cidade = $_POST['cidade'];

        $result = mysqli_query($conexao, "SELECT * FROM editoras WHERE id = $id");

        if(mysqli_num_rows($result) == 1) {
            mysqli_query($conexao, "UPDATE editoras SET nome = '$nome', email = '$email', cidade = '$cidade' WHERE id = '$id'");
            echo "
            <script>
                Swal.fire({
                    title: 'Editora atualizada com sucesso!',
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
                    title: 'Erro ao atualizar editora!',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Publisher.php';})
            </script>";
        }
    }
    ?>
</body>