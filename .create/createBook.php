<!DOCTYPE html>

<head>
   <?php
   $pageTitle = "Criar Livro";
   include("../components/crud/head.php");
   ?>
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

      $sqllivro = "SELECT * FROM livros WHERE nome = '$nome' AND autor = '$autor'";
      $resultado = $conexao->query($sqllivro);

      // Consulta da editora correspondente
      $sqleditora = "SELECT * FROM editoras WHERE nome = '$editora'";
      $resultEditora = $conexao -> query($sqleditora);
      $editora_data = mysqli_fetch_assoc($resultEditora);
      $editora_id = $editora_data['id'];

      if (mysqli_num_rows($resultado) >= 1) {
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
         $result = mysqli_query($conexao, "INSERT INTO livros(nome, autor, editora_id, lancamento, quantidade) VALUES ('$nome', '$autor', '$editora_id', '$lancamento', '$quantidade')");
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