<?php
   include_once('config.php');

   // Usuários
   $sqlUser = "SELECT * FROM usuarios";
   $resultUser = $conexao -> query($sqlUser);

   if($resultUser -> num_rows > 0){
      $data = [];
      while ($row = $resultUser -> fetch_assoc()) {
        $data[] = $row;
      }
      echo json_encode($data);
   } 
   else{
      echo "0 resultados";
   }
?>