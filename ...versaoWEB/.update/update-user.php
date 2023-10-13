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

        // Conexão tabela aluguéis
        $sql_usuario = "SELECT * FROM usuarios WHERE id = $codUsuario";
        $result_usuario = $conexao->query($sql_usuario);
        $usuario_data = mysqli_fetch_assoc($result_usuario);
        $nome_old = $usuario_data['nome'];

        $sql_aluguel = "SELECT * FROM alugueis WHERE usuario = '$nome_old' AND data_devolucao = 0";
        $result_aluguel = $conexao->query($sql_aluguel);

        if ($result_aluguel->num_rows > 0) {
            $UpdateUsuarioName = "UPDATE alugueis SET usuario = '$nomeUsuario' WHERE usuario = '$nome_old'";
            $result = $conexao->query($UpdateUsuarioName);

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
        } else {
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
    }
    ?>
</body>