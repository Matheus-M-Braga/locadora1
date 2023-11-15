<!DOCTYPE html>

<head>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet" href="../css/style.css" media="all">
   <link rel="stylesheet" href="../css/mediaquery.css">
</head>

<body>
   <?php
   // Insert
   if (isset($_POST['submit'])) {
      include_once('../php/config.php');

      $nomeLivro = $_POST['nome-livro'];
      $autor = $_POST['autor'];
      $editora = $_POST['editora'];
      $lancamento = $_POST['lancamento'];
      $quantidade = $_POST['quantidade'];

      $sqllivro = "SELECT * FROM livros WHERE nome = '$nomeLivro' AND autor = '$autor'";
      $resultado = $conexao->query($sqllivro);

      if (mysqli_num_rows($resultado) == 1) {
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
         $result = mysqli_query($conexao, "INSERT INTO livros(nome, autor, editora, lancamento, quantidade) VALUES ('$nomeLivro', '$autor', '$editora', '$lancamento', '$quantidade')");
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