<?php 
include_once('config.php');

$data = array();

// Usuários
$sqlUser = "SELECT * FROM usuarios";
$resultUser = $conexao -> query($sqlUser);

if($resultUser -> num_rows > 0){
   $usuarios = array();
   while ($row = $resultUser -> fetch_assoc()) {
      $id = $row['id']; // Obtém o ID do registro
      $usuarios[$id] = $row; // Usar o ID como índice
   }
   $data['user'] = $usuarios;
} 

// Livros
$sql = "SELECT * FROM livros";
$result = $conexao -> query($sql);

if($result -> num_rows > 0){
   $livros = array();
   while ($row = $result -> fetch_assoc()) {
      $id = $row['id']; // Obtém o ID do registro
      $livros[$id] = $row; // Usar o ID como índice
   }
   $data['livro'] = $livros;
} 
else{
   $data['livro'] = array();
}

// Editoras
$sql = "SELECT * FROM editoras";
$result = $conexao -> query($sql);

if($result -> num_rows > 0){
   $editoras = array();
   while ($row = $result -> fetch_assoc()) {
      $id = $row['id']; // Obtém o ID do registro
      $editoras[$id] = $row; // Usar o ID como índice
   }
   $data['editora'] = $editoras;
} 
else{
   $data['editora'] = array();
}

// Aluguéis
$sql = "SELECT * FROM alugueis";
$resultAlug = $conexao -> query($sql);

if($result -> num_rows > 0){
   $alugueis = array();
   while ($row = $resultAlug -> fetch_assoc()) {
      $id = $row['id']; // Obtém o ID do registro
      $alugueis[$id] = $row; // Usar o ID como índice
   }
   $data['aluguel'] = $alugueis;
} 
else{
   $data['aluguel'] = array();
}

// Armazena todas as consultas
echo json_encode($data);
?>
