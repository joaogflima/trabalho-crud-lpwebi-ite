<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Plataforma ITSM</title>
    <link rel="shortcut icon" href="/ITSM/imagens/ICON.png" type="image/x-icon">

    <!-- Importa Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Estilo geral da página */
        body {
            font-family: "Lato", sans-serif;
            background-color: #f8f9fa;
        }

        /* Barra lateral esquerda */
        .sidenav {
            height: 100vh;
            background-color: #000;
            overflow-x: hidden;
            padding-top: 20px;
            position: fixed;
            width: 40%;
            top: 0;
            left: 0;
        }

        /* Área principal de login */
        .main {
            margin-left: 40%;
            padding: 30px;
        }

        /* Texto da tela lateral */
        .login-main-text {
            margin-top: 1%;
            padding: 60px 30px;
            color: #fff;
        }

        /* Estilo da imagem */
        .login-logo {
            max-width: 300px;
            height: auto;
        }

        /* Botão preto personalizado */
        .btn-black {
            background-color: #000;
            color: #fff;
        }

        /* Botão efeito de passagem de mouse */
        .btn-black:hover {
            background-color: #1a1a1a;
            color: #fff;
        }

    </style>
</head>

<body>
    <!-- Barra lateral esquerda -->
    <div class="sidenav d-flex align-items-center justify-content-center">
        <div class="login-main-text text-center">
            <img src="/ITSM/imagens/ITSM-LOGO-VERTICAL.png" alt="Logo" class="login-logo mb-3">
            <p>Faça login ou registre-se para acessar o sistema.</p>
        </div>
    </div>

    <!-- Área principal de login -->
    <div class="main d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow p-4">
                        <h4 class="mb-4 text-center">Acesse sua conta</h4>
                        <div id="alertContainer">
                            <?php
                                if (isset($_GET['erro'])) {
                                    $erro = $_GET['erro'];

                                    if ($erro == 'senha') {
                                        echo '<div class="alert alert-danger text-center fade show" role="alert">
                                                Senha incorreta!
                                            </div>';
                                    } else if ($erro == 'inativo') {
                                        echo '<div class="alert alert-danger text-center fade show" role="alert">
                                                Usuário inativo! Contate o Administrador do sistema.
                                            </div>';
                                    } else if ($erro == 'usuario') {
                                        echo '<div class="alert alert-danger text-center fade show" role="alert">
                                                Usuário não encontrado! Clique em "Registrar".
                                            </div>';
                                    } else {
                                        echo '<div class="alert alert-danger text-center fade show" role="alert">
                                                Erro desconhecido! Contate o Administrador do sistema.
                                            </div>';
                                    }
                                }

                                if (isset($_GET['sucesso'])) {
                                    echo '<div class="alert alert-success text-center fade show" role="alert">
                                            Cadastro realizado com sucesso! Agora você pode fazer login.
                                        </div>';
                                }
                            ?>
                            <div id="erroMensagem" class="alert alert-danger text-center d-none" role="alert">
                                Preencha o usuário e a senha para continuar.
                            </div>
                        </div>
                        <form action="valida_login.php" method="post" id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuário</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Digite seu usuário" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i> <!-- Ícone de olho aberto -->
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-black">Entrar</button>
                            </div>
                        </form>
                        <form action="cadastro_login.php">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-secondary mt-2">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Alternar visualização da senha
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Fechar alertas automaticamente
        setTimeout(function() {
            const alerts = document.querySelectorAll('#alertContainer .alert');
            alerts.forEach(function(alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500); // Remove do DOM depois do fade
            });
        }, 3000);
    </script>

    <script>
        // Detecta se a página foi restaurada do cache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Se voltou do histórico (cache), limpa os campos
                document.getElementById('username').value = '';
                document.getElementById('password').value = '';
            }
        });
    </script>
</body>
</html>
