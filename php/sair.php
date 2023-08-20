<!DOCTYPE html>

<head>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <link rel="stylesheet" href="../css/style.css?<?php echo rand(1, 1000); ?>" media="all">
   <link rel="stylesheet" href="../css/mediaquery.css?<?php echo rand(1, 1000); ?>">
</head>

<body>
   <?php
   session_start();
   unset($_SESSION['email']);
   unset($_SESSION['senha']);
   echo "
   <script>
      Swal.fire({
         title: 'Usuário desconectado!',
         text: '',
         icon: 'success',
         showConfirmButton: false,
         timer: 1500
      })
      .then(() => {window.location.href = '../index.php';})
   </script>";
   ?>
</body>