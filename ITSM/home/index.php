<?php
session_start();
if($_SESSION["logado"] != true){
  header("Location: /ITSM/login/login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Plataforma ITSM</title>
  <link rel="shortcut icon" href="/ITSM/imagens/ICON.png" type="image/x-icon">

  <!-- Bootstrap CSS -->
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

    .carousel-img {
      height: 400px;
      object-fit: cover;
      border-radius: 10px;
    }

    @media (max-width: 768px) {
      .carousel-img {
        height: 250px;
      }
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
    .container-buttons {
      margin-top: 50px;
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
  <!-- Carrossel -->
  <div class="container my-4">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/ITSM/imagens/IMAGEM-CARROSSEL-1.png" class="d-block w-100 carousel-img" alt="Imagem 1">
        </div>
        <div class="carousel-item">
          <img src="/ITSM/imagens/IMAGEM-CARROSSEL-2.png" class="d-block w-100 carousel-img" alt="Imagem 2">
        </div>
        <div class="carousel-item">
          <img src="/ITSM/imagens/IMAGEM-CARROSSEL-3.png" class="d-block w-100 carousel-img" alt="Imagem 3">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
      </button>
    </div>
  </div>

  <!-- Botões de Ação -->
  <div class="container container-buttons text-center">
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <a href="/ITSM/formulario/form_requisicao.php" class="btn btn-dark btn-lg w-100">
          <i class="bi bi-journal-plus me-2"></i>Solicitar Serviço
        </a>
      </div>
      <div class="col-md-4">
        <a href="/ITSM/formulario/form_incidente.php" class="btn btn-dark btn-lg w-100">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>Reportar Problema
        </a>
      </div>
    </div>
  </div>
</main>

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

</body>
</html>
