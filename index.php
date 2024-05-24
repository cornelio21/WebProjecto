<?php
require_once "./classes/conexao.php";

// Estabelece a conexão com o banco de dados
$con = new Conexao();
$conexao = $con->conectar();

if ($conexao) {
    // Query para verificar se há um super admin
    $sql = "SELECT * FROM usuarios WHERE idRole_Users = 1";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
        // Verifica se há resultados na consulta
        if (mysqli_num_rows($result) > 0) {
            $hasSuperAdmin = true;
        } else {
            $hasSuperAdmin = false;
        }

        // Libera o resultado da consulta
        mysqli_free_result($result);
    } else {
        // Erro na consulta SQL
        echo "Erro na consulta SQL: " . mysqli_error($conexao);
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
} else {
    // Erro na conexão
    echo "Erro na conexão com o banco de dados.";
}

// Agora você pode usar a variável $hasSuperAdmin conforme necessário
?>


<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./libs/bootstrap-5.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Login</title>
</head>

<body>
    <main>
        <section id="login-area" class="text-center">

            <div id="img-login-area">
                <img src="imgs/logo.png" alt="">
            </div>
            <h1>GERECIAMENTO DO TEMPO DE TRABALHO</h1>
            <div class="alert alert-danger fade show alert-login alert-login-invalid" role="alert"><i class="far fa-times-circle fa-lg"></i>Não deixe os campos em branco, preencha com o email e senha de usuário do sistema.</div>


            <form id="login-form" class="mt-4" method="POST">
                <h2>Autenticação</h2>
                <div class="input-group mt-4 mb-4">
                    <span class="input-group-text"><i class="fas fa-user .errors-fields"></i></span>
                    <input autofocus type="email" name="username" id="txtUsername" class="form-control" aria-describedby="txtUsername" placeholder="E-mail do usuário">

                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input type="password" name="password" id="txtPassword" class="form-control" placeholder="Senha do usuário">

                </div>

                <div class="input-group my-4">
                    <p>
                        <button type="submit" class="btn btn-primary shadow-sm" id="btnEfectuarLogin">
                            Entrar
                        </button>


                        <?php
// Verifica se a variável $hasSuperAdmin está definida e não é nula
if (isset($hasSuperAdmin) && !$hasSuperAdmin) :
?>
    <a class="btn-link" href="./views/registar.php">
        ou, Registar (Super admin)
    </a>
<?php endif; ?>

                    </p>
                </div>

            </form>


        </section>

    </main>
    <footer>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                &copy; <?php echo date("Y"); ?> Todos os direitos reservados. Desenvolvido por Cornelio!
            </div>
        </div>
    </div>
</footer>


    <script src="./libs/jquery/jquery-3.5.1.min.js"></script>
    <script src="libs/bootstrap-5.0.0/js/bootstrap.min.js"></script>
    <script defer src="libs/fontawesome-5.15.2/js/all.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        $('#btnEfectuarLogin').on('click', function() {

            $('#login-form').on("submit", function(evento) {
                evento.preventDefault();
            })

            username = $('#txtUsername');
            senha = $('#txtPassword');

            function isNotEmptyLoginFields(field) {
                if (field.val() == "") {
                    $('.alert-login-invalid').fadeIn('fast');
                    $('.alert-login-valid').fadeOut('fast');
                    field.toggleClass('errors-fields');
                    return false;
                } else {
                    field.removeClass('errors-fields');
                    $('.alert-login-valid').fadeIn('fast');
                    $('.alert-login-invalid').fadeOut('fast');
                    return true;
                };
            };

            if (isNotEmptyLoginFields(username) && isNotEmptyLoginFields(senha)) {
                dados = $('#login-form').serialize();
                
                $.ajax({
                    type: "POST",
                    data: dados,
                    url: "./procedimentos/login/efectuarLogin.php",
                    success: function(r) {
                        
                        if (r == 1) {
                            window.location = "./views/home.php";
                            
                        } else {
                            alert("Deu erro");
                        };
                    }
                });

            };

        });
    </script>

</body>

</html>