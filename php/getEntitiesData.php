<?php
include_once('config.php');

$data = array();

// Usuários
$sqlUser = "SELECT * FROM usuarios";
$resultUser = $conexao->query($sqlUser);

if ($resultUser->num_rows > 0) {
   $usuarios = array();
   while ($row = $resultUser->fetch_assoc()) {
      $id = $row['id'];
      $usuarios[$id] = $row;
   }
   $data['User'] = $usuarios;
} else {
   $data['User'] = array();
}

// Livros
$sql = "SELECT * FROM livros";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
   $livros = array();
   while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $livros[$id] = $row;
   }
   $data['Book'] = $livros;
} else {
   $data['Book'] = array();
}

// Editoras
$sql = "SELECT * FROM editoras";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
   $editoras = array();
   while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $editoras[$id] = $row;
   }
   $data['Publisher'] = $editoras;
} else {
   $data['Publisher'] = array();
}

// Aluguéis
$sql = "SELECT * FROM alugueis";
$resultAlug = $conexao->query($sql);

if ($result->num_rows > 0) {
   $alugueis = array();
   while ($row = $resultAlug->fetch_assoc()) {
      $id = $row['id'];
      $alugueis[$id] = $row;
   }
   $data['Rental'] = $alugueis;
} else {
   $data['Rental'] = array();
}

// Envia todos os dados em formato json
echo json_encode($data);
