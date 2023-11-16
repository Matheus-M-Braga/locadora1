<!DOCTYPE html>

<head>
   <?php
   $pageTitle = "Criar Aluguel";
   include("../components/crud/head.php");
   ?>
</head>

<body>
   <?php
   if (isset($_POST['submit'])) {
      include_once('../php/config.php');
      date_default_timezone_set('America/Sao_Paulo');

      $livro = $_POST['livro'];
      $usuario = $_POST['usuario'];
      $data_aluguel = date('Y-m-d');
      $prev_devolucao = $_POST['prev_devolucao'];
      $data_devolucao = $_POST['data_devolucao'];
      $status = "Pendente";


      $sqlSelect = "SELECT * FROM alugueis WHERE livro = '$livro' AND usuario = '$usuario' AND data_devolucao = 0";
      $resultSelect = $conexao->query($sqlSelect);

      if (mysqli_num_rows($resultSelect) == 1) {
         echo "
         <script>
            Swal.fire({
               title: 'Usuário já possui aluguel desse livro!',
               text: '',
               icon: 'error',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../Rental.php';})
         </script>";
      } else {
         // Conexão tabela Livros
         $sqllivro_conect = "SELECT * FROM livros WHERE nome = '$livro'";
         $resultlivro_conect = $conexao->query($sqllivro_conect);

         $livro_data = mysqli_fetch_assoc($resultlivro_conect);
         $nomeLivro_BD = $livro_data['nome'];
         $quantidade_BD = $livro_data['quantidade'];
         $quantidade_nova = $quantidade_BD - 1;

         if ($livro === $nomeLivro_BD && $quantidade_nova >= 0) {
            $sqlAlterar = "UPDATE livros SET quantidade = '$quantidade_nova' WHERE nome = '$livro'";
            $sqlResultAlterar = $conexao->query($sqlAlterar);

            $result = mysqli_query($conexao, "INSERT INTO alugueis(livro, usuario, data_aluguel, prev_devolucao, data_devolucao, status) VALUES ('$livro', '$usuario', '$data_aluguel', '$prev_devolucao', '$data_devolucao', '$status')");
            echo "
            <script>
               Swal.fire({
                  title: 'Aluguel cadastrado com sucesso!',
                  text: '',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 1500
               })
               .then(() => {window.location.href = '../Rental.php';})
            </script>";
         } else if ($quantidade_nova < 0) {
            echo "
            <script>
               Swal.fire({
                  title: 'Livro com estoque esgotado!',
                  text: '',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1500
               })
               .then(() => {window.location.href = '../Rental.php';})
            </script>";
         }
      }
   }
   ?>
</body>