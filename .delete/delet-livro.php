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

        $codLivro = $_GET['id'];

        $sqlSelect = "SELECT * FROM livros WHERE id = $codLivro";

        $result = $conexao->query($sqlSelect);

        $livro_data = mysqli_fetch_assoc($result);
        $nomeLivro = $livro_data['nome'];

        // Conexão tabela alugueis
        $sqlAluguelConect = "SELECT * FROM alugueis WHERE livro = '$nomeLivro' AND data_devolucao = 0";
        $sqlAluguelConect_result = $conexao->query($sqlAluguelConect);

        while ($aluguel_data = mysqli_fetch_assoc($sqlAluguelConect_result)) {
            $alugueisAssociados[] = $aluguel_data;
        }

        if ($alugueisAssociados != null) {
            echo "
            <script>
               Swal.fire({
                  title: 'Livro possui um ou mais aluguéis ativos!',
                  text: '',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../livro.php';})
            </script>";
        } else {
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM livros WHERE CodLivro = $codLivro";
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
               .then(() => {window.location.href = '../livro.php';})
            </script>";
        }
    }
    ?>
</body>