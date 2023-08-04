<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login.css?<?php echo rand(1, 1000); ?>">
    <title>Login</title>
</head>
<body>
    <div class="log">
        <h1>Acesso</h1><br>
        <form action="php/testelogin.php" method="POST" class="needs-validation" novalidate>
            
            <input type="text" placeholder="E-mail" name="email" class="form-control" id="" autocomplete="on" required>
            <div class="invalid-feedback" style="background-color: white; border-radius: 5px; opacity: 12;">
                <b>• Campo obrigatório •</b>
            </div>
            <br>
            <input type="password"  placeholder="Senha" name="senha" class="form-control" id="" autocomplete="off" required>
            <div class="invalid-feedback" style="background-color: white; border-radius: 5px; opacity: 12;">
                <b>• Campo obrigatório •</b>
            </div>
            <br>
            <input type="submit" name="submit" value="Entrar" class="submit">
        </form>
    </div>
    <!-- Script da validação -->
    <script>
            (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
                })
            })()
        </script>
</body>
</html>