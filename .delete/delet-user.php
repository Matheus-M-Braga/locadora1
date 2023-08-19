<?php
if (!empty($_GET['id'])) {
    include_once('../php/config.php');

    $codUsuario = $_GET['id'];

    $sqlSelect = "SELECT * FROM usuarios WHERE CodUsuario = $codUsuario";

    $result = $conexao->query($sqlSelect);
    $user_data = mysqli_fetch_assoc($result);
    $nomeUsuario = $user_data['Nome'];

    // Conexão tabela alugueis
    $sqlAluguel_conect = "SELECT * FROM alugueis WHERE usuario = '$nomeUsuario' AND data_devolucao = 0";
    $sqlAluguel_conect_result = $conexao->query($sqlAluguel_conect);

    while ($aluguel_data = mysqli_fetch_assoc($sqlAluguel_conect_result)) {
        $alugueis_associados[] = $aluguel_data;
    }

    if ($alugueis_associados != null) {
        echo "<script> alert('Usuário não pode ser deletado, pois possui aluguel ativo.'); </script>";
        echo "<script> window.location.href = '../user.php' </script>";
    } else {
        if ($result->num_rows > 0) {
            $sqlDelete = "DELETE FROM usuarios WHERE CodUsuario = $codUsuario";
            $resultDelete = $conexao->query($sqlDelete);
        }
        $sqlReset = "ALTER TABLE usuarios AUTO_INCREMENT = 1;";
        $resultReset = $conexao->query($sqlReset);
        echo "<script> window.location.href = '../user.php' </script>";
    }
} else { 
    echo "Parece que este arquivo não foi acessado corretamente, verifique se o parâmetro de ID está definido na URL. Se não, não há utilidade em estar aqui!";
}
