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

      $nomeUsuario = $_POST['nome-user'];
      $cidade = $_POST['cidade'];
      $endereco = $_POST['endereco'];
      $email = $_POST['email'];

      $sqluser = "SELECT * FROM usuarios WHERE Nome = '$nomeUsuario'";
      $resultado = $conexao->query($sqluser);

      if (mysqli_num_rows($resultado) == 1) {
         echo "
         <script>
            Swal.fire({
               title: 'Usuário já cadastrado!',
               text: '',
               icon: 'error',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../user.php';})
         </script>";
      } else {
         $result = mysqli_query($conexao, "INSERT INTO usuarios(Nome, Cidade, Endereco, Email) VALUES ('$nomeUsuario', '$cidade', '$endereco', '$email')");
         echo "
         <script>
            Swal.fire({
               title: 'Usuário cadastrado com sucesso!',
               text: '',
               icon: 'success',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../user.php';})
         </script>";
      }
   }
   ?>
</body>
