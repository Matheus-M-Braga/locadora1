<!DOCTYPE html>

<head>
    <?php
    $pageTitle = "Excluir Livro";
    include("../components/crud/head.php");
    ?>
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../php/config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM livros WHERE id = $id";

        $result = $conexao->query($sqlSelect);

        $livro_data = mysqli_fetch_assoc($result);
        $nome = $livro_data['nome'];

        // Conexão tabela alugueis
        $sqlAluguelConect = "SELECT * FROM alugueis WHERE livro = '$nome' AND data_devolucao = 0";
        $sqlAluguelConect_result = $conexao->query($sqlAluguelConect);

        while ($aluguel_data = mysqli_fetch_assoc($sqlAluguelConect_result)) {
            $alugueisAssociados[] = $aluguel_data;
        }

        if ($alugueisAssociados != null) {
            echo "
            <script>
               Swal.fire({
                  title: 'Livro possui aluguéis ativos!',
                  text: '',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../Book.php';})
            </script>";
        } else {
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM livros WHERE id = $id";
                $resultDelete = $conexao->query($sqlDelete);
            }
            $sqlReset = "ALTER TABLE livros AUTO_INCREMENT = 1;";
            $resultReset = $conexao->query($sqlReset);
            echo "
            <script>
               Swal.fire({
                  title: 'Livro deletado com sucesso!',
                  text: '',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../Book.php';})
            </script>";
        }
    }
    ?>
</body>