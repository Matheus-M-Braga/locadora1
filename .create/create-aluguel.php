<!DOCTYPE html>

<head>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet" href="../css/style.css?<?php echo rand(1, 1000); ?>" media="all">
   <link rel="stylesheet" href="../css/mediaquery.css?<?php echo rand(1, 1000); ?>">
</head>

<body>
   <?php
   // inserção dos dados na tebela
   if (isset($_POST['submit'])) {
      include_once('../php/config.php');

      date_default_timezone_set('America/Sao_Paulo');

      $entrada = new DateTime(date("Y/m/d", strtotime($_POST['dat_aluguel'])));
      $saida = new DateTime(date("Y/m/d", strtotime($_POST['prev_devolucao'])));

      $intervalo = $entrada->diff($saida);
      $dias = $intervalo->days;

      $hoje = date("Y/m/d");
      $aluguel = $_POST['dat_aluguel'];


      if (strtotime($aluguel) <= strtotime($hoje)) {
         if ($dias > 30) {
            echo "
            <script>
               Swal.fire({
                  title: 'O aluguel tem prazo limite de 30 dias!',
                  text: '',
                  icon: 'error',
                  showConfirmButton: false,
                  timer: 1700
               })
               .then(() => {window.location.href = '../aluguel.php';})
            </script>";
         } else {
            $dat_prev = $_POST['prev_devolucao'];
            $dat_aluga = $_POST['dat_aluguel'];

            if (strtotime($dat_prev) < strtotime($dat_aluga)) {
               echo "
               <script>
                  Swal.fire({
                     title: 'Não há sentido em a data de aluguel ser posterior à devolução '-'!',
                     text: '',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1700
                  })
                  .then(() => {window.location.href = '../aluguel.php';})
               </script>";
            } else {
               $nomeLivro = $_POST['nome-livro'];
               $usuario = $_POST['usuario'];
               $dat_aluguel = $_POST['dat_aluguel'];
               $prev_devolucao = $_POST['prev_devolucao'];
               $data_devolucao = $_POST['data_devolucao'];

               $sqlSelect = "SELECT * FROM alugueis WHERE livro = '$nomeLivro' AND usuario = '$usuario'";
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
                     .then(() => {window.location.href = '../aluguel.php';})
                  </script>";
               } else {
                  // Conexão tabela Livros
                  $sqllivro_conect = "SELECT * FROM livros WHERE nome = '$nomeLivro'";
                  $resultlivro_conect = $conexao->query($sqllivro_conect);

                  $livro_data = mysqli_fetch_assoc($resultlivro_conect);
                  $nomeLivro_BD = $livro_data['nome'];
                  $quantidade_BD = $livro_data['quantidade'];
                  $quantidade_nova = $quantidade_BD - 1;

                  if ($nomeLivro === $nomeLivro_BD && $quantidade_nova >= 0) {
                     $sqlAlterar = "UPDATE livros SET quantidade = '$quantidade_nova' WHERE nome = '$nomeLivro'";
                     $sqlResultAlterar = $conexao->query($sqlAlterar);

                     $result = mysqli_query($conexao, "INSERT INTO alugueis(livro, usuario, data_aluguel, prev_devolucao, data_devolucao) VALUES ('$nomeLivro', '$usuario', '$dat_aluguel', '$prev_devolucao', '$data_devolucao')");
                     echo "
                     <script>
                        Swal.fire({
                           title: 'Aluguel cadastrado com sucesso!',
                           text: '',
                           icon: 'success',
                           showConfirmButton: false,
                           timer: 1500
                        })
                        .then(() => {window.location.href = '../aluguel.php';})
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
                        .then(() => {window.location.href = '../aluguel.php';})
                     </script>";
                  }
               }
            }
         }
      } else {
         echo "
         <script>
            Swal.fire({
               title: 'Data de aluguel não pode ser posterior ao dia de hoje!',
               text: '',
               icon: 'error',
               showConfirmButton: false,
               timer: 1700
            })
            .then(() => {window.location.href = '../aluguel.php';})
         </script>";
      }
   }
   ?>
</body>