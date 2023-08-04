<?php
   include_once('config.php');

   // Editoras
   $sqlEdit = "SELECT * FROM usuarios";
   $resultEdit = $conexao -> query($sqlEdit);

   if($resultEdit -> num_rows > 0){
      $dataEdit = array();
      while ($row = $resultEdit -> fetch_assoc()) {
        $dataEdit[] = $row;
      }
      echo json_encode($dataEdit);
   } 
   else{
      echo "0 resultados";
   }
?>