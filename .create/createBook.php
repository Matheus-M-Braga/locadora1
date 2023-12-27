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
      $autor = $_POST['autor'];
      $editora = $_POST['editora'];
      $lancamento = $_POST['lancamento'];
      $quantidade = $_POST['quantidade'];

      $result = mysqli_query($conexao, "SELECT * FROM livros WHERE nome = '$nome' AND autor = '$autor'");

      $resultEditora = mysqli_query($conexao, "SELECT * FROM editoras WHERE nome = '$editora'");
      $editora_data = mysqli_fetch_assoc($resultEditora);
      $editora_id = $editora_data['id'];

      if (mysqli_num_rows($result) >= 1) {
         echo "
         <script>
            Swal.fire({
               title: 'Livro já cadastrado!',
               text: '',
               icon: 'error',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../Book.php';})
         </script>";
      } else {
         mysqli_query($conexao, "INSERT INTO livros(nome, autor, editora_id, lancamento, quantidade) VALUES ('$nome', '$autor', '$editora_id', '$lancamento', '$quantidade')");
         echo "
         <script>
            Swal.fire({
               title: 'Livro cadastrado com sucesso!',
               text: '',
               icon: 'success',
               showConfirmButton: false,
               timer: 1500
            })
            .then(() => {window.location.href = '../Book.php';})
         </script>";
      }
   }
   ?>
</body>