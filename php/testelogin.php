<!DOCTYPE html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css?<?php echo rand(1, 1000); ?>" media="all">
    <link rel="stylesheet" href="../css/mediaquery.css?<?php echo rand(1, 1000); ?>">
</head>

<body>
    <?php
    session_start();
    if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {

        include_once('config.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM gerenciadores WHERE usuario = '$email' and senha = '$senha'";

        $result = $conexao->query($sql);


        if (mysqli_num_rows($result) < 1) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            echo "
            <script>
                Swal.fire({
                    title: 'Nenhum registro encontrado!',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                })
                .then(() => {window.location.href = '../index.php';})
            </script>";
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            echo "
            <script>
                Swal.fire({
                    title: 'Usuário logado!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                })
                .then(() => {window.location.href = '../inicio.php';})
            </script>";
        }
    } else {
        echo "
        <script>
            Swal.fire({
                title: 'Nenhum registro encontrado!',
                text: '',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            })
            .then(() => {window.location.href = '../index.php';})
        </script>";
    }
    ?>
</body>