<?php
   include_once('config.php');

   // Livros
   $sqlBook = "SELECT * FROM livros";
   $result = $conexao -> query($sqlBook);

   if($result -> num_rows > 0){
      $data = array();
      while ($row = $result -> fetch_assoc()) {
        $data[] = $row;
      }
      echo json_encode($data);
   } 
   else{
      echo "0 resultados";
   }
?>