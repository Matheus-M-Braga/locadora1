<!DOCTYPE html>

<head>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet" href="../css/style.css?<?php echo rand(1, 1000); ?>" media="all">
   <link rel="stylesheet" href="../css/mediaquery.css?<?php echo rand(1, 1000); ?>">
</head>

<body>
   <?php
   // Insert
   if (isset($_POST['submit'])) {

      include_once('../php/config.php');

      $nomeEditora = $_POST['nome-editora'];
      $email = $_POST['email-editora'];
      $telefone = $_POST['telefone-editora'];
      $website = $_POST['site-editora'];

      $sqleditora = "SELECT * FROM editoras WHERE nome = '$nomeEditora'";
      $resultado = $conexao->query($sqleditora);

      if (mysqli_num_rows($resultado) == 1) {
         echo "
         <script>
            Swal.fire({
               title: 'Editora já cadastrada!',
               text: '',
               icon: 'error',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../editora.php';})
         </script>";
      } else {
         $resultI = mysqli_query($conexao, "INSERT INTO editoras(nome, email, telefone, website) VALUES ('$nomeEditora', '$email', '$telefone', '$website')");
         echo "
         <script>
            Swal.fire({
               title: 'Editora cadastrada com sucesso!',
               text: '',
               icon: 'success',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../editora.php';})
         </script>";
      }
   }
   ?>
</body>