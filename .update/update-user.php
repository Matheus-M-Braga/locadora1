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

        $codUsuario = $_POST['id'];
        $nomeUsuario = $_POST['nome-user'];
        $cidade = $_POST['cidade'];
        $endereco = $_POST['endereco'];
        $email = $_POST['email'];

        $sqlUpdate = "UPDATE usuarios SET Nome = '$nomeUsuario', Cidade = '$cidade', Endereco = '$endereco', Email = '$email' WHERE id = '$codUsuario'";

        $result = $conexao->query($sqlUpdate);

        echo "
        <script>
            Swal.fire({
                title: 'Usuário atualizado com sucesso!',
                text: '',
                icon: 'success',
                showConfirmButton: false,
                timer: 1700
            })
            .then(() => {window.location.href = '../user.php';})
        </script>";
    }
    ?>
</body>