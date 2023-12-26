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

      $nome = $_POST['nome'];
      $cidade = $_POST['cidade'];
      $endereco = $_POST['endereco'];
      $email = $_POST['email'];

      $resultado = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email'");

      if (mysqli_num_rows($resultado) >= 1) {
         echo "
         <script>
            Swal.fire({
               title: 'Email já cadastrado!',
               text: '',
               icon: 'error',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../User.php';})
         </script>";
      } else {
         mysqli_query($conexao, "INSERT INTO usuarios(nome, cidade, endereco, email) VALUES ('$nome', '$cidade', '$endereco', '$email')");
         echo "
         <script>
            Swal.fire({
               title: 'Usuário cadastrado com sucesso!',
               text: '',
               icon: 'success',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../User.php';})
         </script>";
      }
   }
   ?>
</body>