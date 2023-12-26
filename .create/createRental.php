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
   if (isset($_POST['submit'])) {
      include_once('../php/config.php');
      date_default_timezone_set('America/Sao_Paulo');

      $livro = $_POST['livro'];
      $usuario = $_POST['usuario'];
      $data_aluguel = date('Y-m-d');
      $prev_devolucao = $_POST['prev_devolucao'];
      $data_devolucao = null;
      $status = "Pendente";

      // Consulta do livro correspondente
      $resultLivro = mysqli_query($conexao, "SELECT * FROM livros WHERE nome = '$livro'");
      $livro_data = mysqli_fetch_assoc($resultLivro);
      $livro_id = $livro_data['id'];

      // Consulta do usuário correspondente
      $resultUsuario = mysqli_query($conexao, "SELECT * FROM usuarios WHERE nome = '$usuario'");
      $usuario_data = mysqli_fetch_assoc($resultUsuario);
      $usuario_id = $usuario_data['id'];

      $sqlSelect = "SELECT * FROM alugueis WHERE livro_id = '$livro_id' AND usuario_id = '$usuario_id' AND data_devolucao = 0";
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
         $quantidade = $livro_data['quantidade'] - 1;
         if ($quantidade >= 0) {
            $alugados = $livro_data['alugados'] + 1;
            mysqli_query($conexao, "UPDATE livros SET quantidade = '$quantidade', alugados = '$alugados' WHERE id = '$livro_id'");
            mysqli_query($conexao, "INSERT INTO alugueis(livro_id, usuario_id, data_aluguel, prev_devolucao, data_devolucao, status) VALUES ('$livro_id', '$usuario_id', '$data_aluguel', '$prev_devolucao', '$data_devolucao', '$status')");
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
         } else if ($quantidade < 0) {
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