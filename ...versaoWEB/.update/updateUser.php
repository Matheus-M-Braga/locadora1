<!DOCTYPE html>

<head>
    <?php
    $pageTitle = "Atualizar Usuário";
    include("../components/crud/head.php");
    ?>
</head>

<body>
    <?php
    include_once('../php/config.php');

    if (isset($_POST['submit'])) {

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $endereco = $_POST['endereco'];
        $email = $_POST['email'];

        // Conexão tabela aluguéis
        $sql_usuario = "SELECT * FROM usuarios WHERE id = $id";
        $result_usuario = $conexao->query($sql_usuario);
        $usuario_data = mysqli_fetch_assoc($result_usuario);
        $nome_old = $usuario_data['nome'];

        $sql_aluguel = "SELECT * FROM alugueis WHERE usuario = '$nome_old' AND data_devolucao = 0";
        $result_aluguel = $conexao->query($sql_aluguel);

        if ($result_aluguel->num_rows > 0) {
            $UpdateUsuarioName = "UPDATE alugueis SET usuario = '$nome' WHERE usuario = '$nome_old'";
            $result = $conexao->query($UpdateUsuarioName);

            $sqlUpdate = "UPDATE usuarios SET Nome = '$nome', Cidade = '$cidade', Endereco = '$endereco', Email = '$email' WHERE id = '$id'";
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
                .then(() => {window.location.href = '../User.php';})
            </script>";
        } else {
            $sqlUpdate = "UPDATE usuarios SET Nome = '$nome', Cidade = '$cidade', Endereco = '$endereco', Email = '$email' WHERE id = '$id'";
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
                .then(() => {window.location.href = '../User.php';})
            </script>";
        }
    }
    ?>
</body>