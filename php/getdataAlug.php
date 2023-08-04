<?php
   include_once('config.php');

   // Aluguéis
   $sqlAlug = "SELECT * FROM usuarios";
   $resultAlug = $conexao -> query($sqlAlug);

   if($resultAlug -> num_rows > 0){
      $dataAlug = array();
      while ($row = $resultAlug -> fetch_assoc()) {
        $dataAlug[] = $row;
      }
      echo json_encode($dataAlug);
   } 
   else{
      echo "0 resultados";
   }
?>