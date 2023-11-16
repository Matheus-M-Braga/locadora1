<!DOCTYPE html>

<head>
   <?php
    $pageTitle = "Criar Editora";
    include("../components/crud/head.php");
   ?>
</head>

<body>
   <?php
   // Insert
   if (isset($_POST['submit'])) {

      include_once('../php/config.php');

      $nomeEditora = $_POST['nome-editora'];
      $email = $_POST['email-editora'];
      $cidade = $_POST['cidade-editora'];

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
            .then(() => {window.location.href = '../Publisher.php';})
         </script>";
      } else {
         $resultI = mysqli_query($conexao, "INSERT INTO editoras(nome, email, cidade) VALUES ('$nomeEditora', '$email', '$cidade')");
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