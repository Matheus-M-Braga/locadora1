<?php
   include_once('config.php');

   // Livros
   $sql = "SELECT * FROM livros";
   $result = $conexao -> query($sql);

   if($result -> num_rows > 0){
      $data = array();
      while ($row = $result -> fetch_assoc()) {
         $id = $row['CodLivro'];
         $data[$id] = $row;
      }
      echo json_encode($data);
   } 
   else{
      echo "0 resultados";
   }
?>