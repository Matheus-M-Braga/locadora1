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

        $codEditora = $_POST['id'];
        $nomeEditora = $_POST['nome-editora'];
        $email = $_POST['email-editora'];
        $telefone = $_POST['telefone-editora'];

        // Conexão tabela livros
        $sql_editora = "SELECT * FROM editoras WHERE id = $codEditora";
        $result_editora = $conexao -> query($sql_editora);
        $editora_data = mysqli_fetch_assoc($result_editora);
        $nome_old = $editora_data['nome'];

        $sql_livro = "SELECT * FROM livros WHERE editora = '$nome_old'";
        $result_livro = $conexao->query($sql_livro);

        if ($result_livro->num_rows > 0) {
            echo "
            <script>
                Swal.fire({
                    title: 'Editora possui associação com livros, não pode sofrer alterações!',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../editora.php';})
            </script>";
        } else {
            $sqlUpdate = "UPDATE editoras SET nome = '$nomeEditora', email = '$email', telefone = '$telefone' WHERE id = '$codEditora'";

            $result = $conexao->query($sqlUpdate);
            echo "
            <script>
                Swal.fire({
                    title: 'Editora atualizada com sucesso!',
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