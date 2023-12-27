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
      $email = $_POST['email'];
      $cidade = $_POST['cidade'];

      $result = mysqli_query($conexao, "SELECT * FROM editoras WHERE nome = '$nome'");

      if (mysqli_num_rows($result) >= 1) {
         echo "
         <script>
            Swal.fire({
               title: 'Editora já cadastrada!',
               text: '',
               icon: 'error',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../Publisher.php';})
         </script>";
      } else {
         mysqli_query($conexao, "INSERT INTO editoras(nome, email, cidade) VALUES ('$nome', '$email', '$cidade')");
         echo "
         <script>
            Swal.fire({
               title: 'Editora cadastrada com sucesso!',
               text: '',
               icon: 'success',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../Publisher.php';})
         </script>";
      }
   }
   ?>
</body>