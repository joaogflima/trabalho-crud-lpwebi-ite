<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Usuário</title>
  <link rel="shortcut icon" href="/ITSM/imagens/ICON.png" type="image/x-icon">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .btn-black {
            background-color: black;
            color: white;
        }
        .btn-black:hover {
            background-color: #333;
            color: white;
        }
        .navbar {
            background-color: black;
            position: relative;
            height: 80px;
            padding: 0 1rem;
        }

        .navbar-brand img {
            height: 45px;
            width: auto;
        }

        .navbar-title {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 8px;
            white-space: nowrap;
        }

        .custom-border {
            border: 1px solid white;
        }
        footer {
          background-color: #212529;
          color: white;
          padding: 5px 0;
        }

        footer a {
          color: #ccc;
          text-decoration: none;
        }

        footer a:hover {
          color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black position-relative">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="/ITSM/imagens/ITSM-LOGO-HORIZONTAL.png" alt="Logo">
    </a>

    <div class="navbar-title bg-black text-white px-2 py-0 rounded custom-border">
      Cadastro de Usuário
    </div>
  </div>
</nav>

<!-- Formulário -->
<div class="form-container">
  <form action="processa_cadastro.php" method="post" onsubmit="return validarCadastro()">
    <div id="alerta-senhas" class="alert alert-danger text-center d-none" role="alert">
      As senhas não coincidem.
    </div>
    <?php
        if (isset($_GET['erro'])) {
            $mensagem = '';

            switch ($_GET['erro']) {
                case 'usuario_existente':
                    $mensagem = 'Este nome de usuário já está em uso.';
                    break;
                default:
                    $mensagem = 'Ocorreu um erro ao tentar cadastrar. Tente novamente.';
                    break;
            }

            echo "<div class='alert alert-danger text-center'>$mensagem</div>";
        }
    ?>
    <div class="mb-3">
      <label for="nome" class="form-label">Nome Completo</label>
      <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
    </div>
    <div class="mb-3">
      <label for="username" class="form-label">Usuário</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Escolha um usuário" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Senha</label>
      <div class="input-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>
    <div class="mb-3">
      <label for="confirm_password" class="form-label">Confirmar Senha</label>
      <div class="input-group">
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirme sua senha" required>
        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>
    <div class="d-flex justify-content-center gap-3 mt-4">
      <button type="button" class="btn btn-outline-secondary" onclick="history.back();">Voltar</button>
      <button type="submit" class="btn btn-black">Cadastrar</button>
    </div>
  </form>
</div>

<footer class="mt-5 bg-dark text-white">
  <div class="container py-4">
    <div class="row justify-content-center text-center">
      <div class="col-md-6 mb-4">
        <h5>Sobre a Plataforma</h5>
        <p>A Plataforma ITSM conecta pessoas, processos e tecnologia para oferecer suporte e gestão de serviços com mais agilidade, transparência e qualidade.</p>
      </div>
      <div class="col-md-6 mb-4">
        <h5>Contato</h5>
        <ul class="list-unstyled">
          <li><i class="bi bi-envelope-fill me-2"></i>contato@itsm.com</li>
          <li><i class="bi bi-telephone-fill me-2"></i>(00) 1234-5678</li>
          <li><i class="bi bi-geo-alt-fill me-2"></i>Rua Exemplo, 123 - Cidade</li>
        </ul>
      </div>
    </div>

    <div class="text-center pt-3">
      <small class="text-secondary">&copy; 2025 Plataforma ITSM - Todos os direitos reservados.</small>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
    // Mostrar/ocultar senha
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.querySelector('i').classList.toggle('bi-eye');
    this.querySelector('i').classList.toggle('bi-eye-slash');
    });

    // Mostrar/ocultar confirmação de senha
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#confirm_password');

    toggleConfirmPassword.addEventListener('click', function () {
    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPassword.setAttribute('type', type);
    this.querySelector('i').classList.toggle('bi-eye');
    this.querySelector('i').classList.toggle('bi-eye-slash');
    });

    // Validação simples do formulário
    function validarCadastro() {
        const senha = document.getElementById('password').value.trim();
        const confirmSenha = document.getElementById('confirm_password').value.trim();
        const alertaSenhas = document.getElementById('alerta-senhas');

        if (senha !== confirmSenha) {
            alertaSenhas.classList.remove('d-none'); // Mostra o alerta
            return false;
        } else {
            alertaSenhas.classList.add('d-none'); // Garante que esconde se estiver correto
            return true;
        }
    }
</script>

</body>
</html>
