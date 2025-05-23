<?php
session_start();
if($_SESSION["logado"] != true){
  header("Location: /ITSM/login/login.php");
  exit();
}
include("conexao_banco_form.php");

$id = @$_GET['id'];
$usuario = [];

if (!empty($id)) {
  $sql = "SELECT * FROM usuarios WHERE id = '$id'";
  $resultado = $con->query($sql);
  if ($resultado && $resultado->num_rows > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
  } else {
    $_SESSION['mensagem'] = "Usuário não encontrado.";
    header("Location: /ITSM/lista/usuarios.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Senha | Plataforma ITSM</title>
  <link rel="shortcut icon" href="/ITSM/imagens/ICON.png" type="image/x-icon">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    html, body {
      height: 100%;
      display: flex;
      flex-direction: column;
      margin: 0;
      padding: 0;
    }

    main {
      flex: 1 0 auto;
    }

    body {
      background-color: #f8f9fa;
    }

    .form-container {
      width: 100%;
      max-width: 900px;
      margin: 50px auto;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .navbar {
      background-color: black;
      position: relative;
      height: 60px;
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

    .navbar-nav .nav-link {
      color: white;
      font-weight: 500;
    }

    .navbar-nav .nav-link:hover {
      color: rgb(76, 83, 94);
    }

    .navbar-nav .nav-link.active {
      color: white;
    }

    .navbar-nav .nav-link.active:hover {
      color: rgb(76, 83, 94);
    }

    .user-photo {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .btn-dark {
      background-color: black;
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }

    .btn-dark:hover {
      background-color: #333;
      transform: scale(1.05);
    }

    footer {
      background-color: #212529;
      color: white;
      padding: 30px 0;
      margin-top: auto;
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
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid ps-3">
    <a class="navbar-brand" href="/ITSM/home/index.php">
      <img src="/ITSM/imagens/ITSM-LOGO-HORIZONTAL.png" alt="Logo">
    </a>

    <div class="navbar-title bg-black text-white px-2 py-0 rounded custom-border">
      Alterar Senha
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/ITSM/home/index.php">Início</a>
        </li>
        <?php if($_SESSION["usuario_funcao"] == "Atendente" || $_SESSION["usuario_funcao"] == "Administrador"): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Atendimento
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="/ITSM/lista/incidentes.php">Incidente</a></li>
              <li><a class="dropdown-item" href="/ITSM/lista/requisicoes.php">Requisição</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Pesquisa -->
      <form class="d-flex me-3" role="search" method="GET" action="/ITSM/lista/solicitacoes_geral.php">
        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search" name="pesquisa" required>
        <button class="btn btn-outline-light" type="submit">Buscar</button>
      </form>

      <!-- Perfil -->
      <div class="dropdown">
        <button class="btn dropdown-toggle d-flex align-items-center border-0 bg-transparent text-white" id="userDropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="me-2">Olá, 
            <?php 
              $primeiro_nome = explode(' ', $_SESSION['usuario_nome']);
              echo htmlspecialchars($primeiro_nome[0]); 
            ?>!
          </span>
          <img src="/ITSM/imagens/foto_perfil.png" class="user-photo">
        </button>
        <ul class="dropdown-menu dropdown-menu-end bg-white" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="/ITSM/formulario/form_perfil.php">Perfil</a></li>
          <li><a class="dropdown-item" href="/ITSM/lista/solicitacoes_geral.php?criado_por=me">Minhas solicitações</a></li>
          <?php if($_SESSION["usuario_funcao"] == "Administrador"): ?>
            <li><a class="dropdown-item" href="/ITSM/lista/usuarios.php">Usuários</a></li>
          <?php endif; ?>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="/ITSM/home/logout.php">Sair</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<main>
<!-- Formulário de Alterar Senha -->
<div class="form-container">
    <?php if (isset($_GET['mensagem'])): ?>
      <?php if ($_GET['mensagem'] == 'atualizado'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>
          Atualização realizada com sucesso!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
      <?php elseif ($_GET['mensagem'] == 'erro'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          Erro ao atualizar, tente novamente!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <form action="atualiza_registro.php" method="post" onsubmit="return validarCadastro()">
        <input type="hidden" name="id" value="<?php 
          echo isset($_GET['id']) ? htmlspecialchars($id) : $_SESSION['usuario_id']; 
        ?>">
      <div class="mb-3">
        <label for="username" class="form-label">Usuário</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php
          if(isset($_GET["id"])){
            echo htmlspecialchars($usuario["login"]);
          } else {
            echo htmlspecialchars($_SESSION['usuario_login']);
          }
         ?>" 
         readonly required>
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
        <div id="alerta-senhas" class="alert alert-danger mt-2 d-none" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> As senhas não coincidem.
        </div>
      </div>
      <div class="d-flex justify-content-center gap-3 mt-4">
        <button type="button" class="btn btn-outline-secondary" onclick="history.back();">Voltar</button>
        <button type="submit" class="btn btn-dark" id="btnAtualizar">Atualizar</button>
      </div>
    </form>
</div>
</main>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <h5>Sobre a Plataforma</h5>
        <p>A Plataforma ITSM conecta pessoas, processos e tecnologia para oferecer suporte e gestão de serviços com mais agilidade, transparência e qualidade.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h5>Links Rápidos</h5>
        <ul class="list-unstyled">
          <li><a href="/ITSM/home/index.php">Início</a></li>
          <li><a href="/ITSM/formulario/form_requisicao.php">Solicitar Serviço</a></li>
          <li><a href="/ITSM/formulario/form_incidente.php">Reportar Problema</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-4">
        <h5>Contato</h5>
        <ul class="list-unstyled">
          <li><i class="bi bi-envelope-fill me-2"></i> contato@itsm.com</li>
          <li><i class="bi bi-telephone-fill me-2"></i> (00) 1234-5678</li>
          <li><i class="bi bi-geo-alt-fill me-2"></i> Rua Exemplo, 123 - Cidade</li>
        </ul>
      </div>
    </div>

    <div class="text-center pt-3">
      <small class="text-secondary">&copy; 2025 Plataforma ITSM - Todos os direitos reservados.</small>
    </div>
  </div>
</footer>

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

    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#confirm_password');
    toggleConfirmPassword.addEventListener('click', function () {
      const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPassword.setAttribute('type', type);
      this.querySelector('i').classList.toggle('bi-eye');
      this.querySelector('i').classList.toggle('bi-eye-slash');
    });

    function validarCadastro() {
      const senha = document.getElementById('password').value.trim();
      const confirmSenha = document.getElementById('confirm_password').value.trim();
      const alertaSenhas = document.getElementById('alerta-senhas');

      if (senha !== confirmSenha) {
          alertaSenhas.classList.remove('d-none');
          return false;
      } else {
          alertaSenhas.classList.add('d-none');
          return true;
      }
    }
</script>

</body>
</html>
