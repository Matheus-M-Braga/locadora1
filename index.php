<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css?<?php echo rand(1, 1000); ?>">
    <title>WDA Livraria</title>
</head>

<body>
    <div class="log">
        <h1 class="title">Login</h1>
        <form action="index.php" method="POST" class="needs-validation form" novalidate>
            <input type="text" placeholder="Usuário" name="email" class="form-control" id="" autocomplete="on" required>
            <p class="invalid-feedback">*Informe o usuário</p>
            <input type="password" placeholder="Senha" name="senha" class="form-control" id="" autocomplete="off" required>
            <p class="invalid-feedback">*Informe a senha</p>
            <input type="submit" name="submit" value="Entrar" class="submit">
        </form>
    </div>
    <!-- Script da validação -->
    <script>
        (function() {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
    <!-- Login -->
    <?php
    session_start();
    if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {

        include_once('php/config.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM gerenciadores WHERE usuario = '$email' and senha = '$senha'";

        $result = $conexao->query($sql);


        if (mysqli_num_rows($result) < 1) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            echo "
            <script>
                Swal.fire({
                    title: 'Nenhum registro encontrado!',
                    text: '',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>";
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            echo "
            <script>
                Swal.fire({
                    title: 'Usuário logado!',
                    text: '',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                })
                .then(() => {window.location.href = '../inicio.php';})
            </script>";
        }
    }
    ?>
</body>
</html>