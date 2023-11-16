<!DOCTYPE html>

<head>
    <?php
    $pageTitle = "Excluir Aluguel";
    include("../components/crud/head.php");
    ?>
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../php/config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM alugueis WHERE id = $id";

        $result = $conexao->query($sqlSelect);

        if ($result->num_rows > 0) {
            $sqlDelete = "DELETE FROM alugueis WHERE id = $id";
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