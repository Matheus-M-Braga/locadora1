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

        $sqlSelect = "SELECT * FROM usuarios WHERE id = $id";

        $result = $conexao->query($sqlSelect);
        $user_data = mysqli_fetch_assoc($result);
        $nome = $user_data['nome'];

        // Conexão tabela alugueis
        $sqlAluguel_conect = "SELECT * FROM alugueis WHERE usuario = '$nome' AND data_devolucao = 0";
        $sqlAluguel_conect_result = $conexao->query($sqlAluguel_conect);

        while ($aluguel_data = mysqli_fetch_assoc($sqlAluguel_conect_result)) {
            $alugueis_associados[] = $aluguel_data;
        }

        if ($alugueis_associados != null) {
            echo "
            <script>
               Swal.fire({
                  title: 'Usuário possui aluguéis ativos!',
                  text: '',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../User.php';})
            </script>";
        } else {
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM usuarios WHERE id = $id";
                $resultDelete = $conexao->query($sqlDelete);
            }
            $sqlReset = "ALTER TABLE usuarios AUTO_INCREMENT = 1;";
            $resultReset = $conexao->query($sqlReset);
            echo "
            <script>
               Swal.fire({
                  title: 'Usuário deletado com sucesso!',
                  text: '',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../User.php';})
            </script>";
        }
    } else {
        echo "Parece que este arquivo não foi acessado corretamente, verifique se o parâmetro de ID está definido na URL. Se não, não há utilidade em estar aqui!";
    }
    ?>
</body>