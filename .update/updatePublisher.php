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
    include_once('../php/config.php');

    if (isset($_POST['submit'])) {

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cidade = $_POST['cidade'];

        // Conexão tabela livros
        $sql_editora = "SELECT * FROM editoras WHERE id = $id";
        $result_editora = $conexao->query($sql_editora);
        $editora_data = mysqli_fetch_assoc($result_editora);
        $nome_old = $editora_data['nome'];

        $sql_livro = "SELECT * FROM livros WHERE editora = '$nome_old'";
        $result_livro = $conexao->query($sql_livro);

        if ($result_livro->num_rows > 0) {
            $UpdateEditoraName = "UPDATE livros SET editora = '$nome' WHERE editora = '$nome_old'";
            $result = $conexao->query($UpdateEditoraName);
            $sqlUpdate = "UPDATE editoras SET nome = '$nome', email = '$email', cidade = '$cidade' WHERE id = '$id'";
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
                .then(() => {window.location.href = '../Publisher.php';})
            </script>";
        } else {
            $sqlUpdate = "UPDATE editoras SET nome = '$nome', email = '$email', cidade = '$cidade' WHERE id = '$id'";
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
                .then(() => {window.location.href = '../Publisher.php';})
            </script>";
        }
    }
    ?>
</body>