<?php
   include_once('config.php');

   // Editoras
   $sql = "SELECT * FROM editoras";
   $result = $conexao -> query($sql);

   if($result -> num_rows > 0){
      $data = array();
      while ($row = $result -> fetch_assoc()) {
         $id = $row['CodEditora'];
         $data[$id] = $row;
      }
      echo json_encode($data);
   } 
   else{
      echo "0 resultados";
   }
?>