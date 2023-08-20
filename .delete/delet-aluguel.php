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

        $codAluguel = $_GET['id'];

        $sqlSelect = "SELECT * FROM alugueis WHERE CodAluguel = $codAluguel";

        $result = $conexao->query($sqlSelect);

        if ($result->num_rows > 0) {
            $sqlDelete = "DELETE FROM alugueis WHERE CodAluguel = $codAluguel";
            $resultDelete = $conexao->query($sqlDelete);
        }
        $sqlReset = "ALTER TABLE alugueis AUTO_INCREMENT = 1;";
        $resultReset = $conexao->query($sqlReset);

        echo "
        <script>
            Swal.fire({
                title: 'Aluguel deletado com sucesso!',
                text: '',
                icon: 'success',
                showConfirmButton: false,
                timer: 1700
            })
            .then(() => {window.location.href = '../aluguel.php';})
        </script>";
    }
    ?>
</body>