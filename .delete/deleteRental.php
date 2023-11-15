<!DOCTYPE html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css" media="all">
    <link rel="stylesheet" href="../css/mediaquery.css">
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../php/config.php');

        $codAluguel = $_GET['id'];

        $sqlSelect = "SELECT * FROM alugueis WHERE id = $codAluguel";

        $result = $conexao->query($sqlSelect);

        if ($result->num_rows > 0) {
            $sqlDelete = "DELETE FROM alugueis WHERE id = $codAluguel";
            $resultDelete = $conexao->query($sqlDelete);
            echo "
            <script>
                Swal.fire({
                    title: 'Aluguel deletado com sucesso!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1700
                })
                .then(() => {window.location.href = '../Rental.php';})
            </script>";
        }
        $sqlReset = "ALTER TABLE alugueis AUTO_INCREMENT = 1;";
        $resultReset = $conexao->query($sqlReset);
    }
    ?>
</body>