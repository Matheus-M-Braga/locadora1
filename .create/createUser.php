<!DOCTYPE html>

<head>
   <?php
    $pageTitle = "Criar Usuário";
    include("../components/crud/head.php");
   ?>
</head>

<body>
   <?php
   if (isset($_POST['submit'])) {
      include_once('../php/config.php');

      $nome = $_POST['nome'];
      $cidade = $_POST['cidade'];
      $endereco = $_POST['endereco'];
      $email = $_POST['email'];

      $sqluser = "SELECT * FROM usuarios WHERE email = '$email'";
      $resultado = $conexao->query($sqluser);

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
         $result = mysqli_query($conexao, "INSERT INTO usuarios(Nome, Cidade, Endereco, Email) VALUES ('$nome', '$cidade', '$endereco', '$email')");
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