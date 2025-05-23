<?php
session_start();
if($_SESSION["logado"] != true){
  header("Location: /ITSM/login/login.php");
  exit();
}
include("conexao_banco_form.php");

$codigo = @$_GET['codigo'];
$incidente = [
    'titulo' => '',
    'descricao' => '',
    'status' => '',
    'prioridade' => '',
    'criado_por' => '',
    'atribuido_para' => ''
];

if (!empty($codigo)) {
    $sql = "SELECT * FROM incidentes WHERE codigo='$codigo'";
    $resultado = $con->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $incidente = mysqli_fetch_assoc($resultado);
    }
}
$isReadOnly = (in_array($incidente['status'], [7, 8, 4]) && $_SESSION["usuario_funcao"] != "Administrador") || ($_SESSION["usuario_funcao"] == "Solicitante" && !empty($codigo));
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidente | Plataforma ITSM</title>
    <link rel="shortcut icon" href="/ITSM/imagens/ICON.png" type="image/x-icon">

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
        <?php echo $codigo ? "Incidente | " . htmlspecialchars($codigo) : "Incidente"; ?>
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

<!-- Formulário -->
<main>
  <div class="form-container">

      <?php if (isset($_GET['mensagem']) && $_GET['mensagem'] == 'atualizado'): ?>
          <div class="text-center mb-4">
              <span class="badge bg-success p-2">Registro atualizado com sucesso!</span>
          </div>
      <?php elseif (isset($_GET['mensagem']) && $_GET['mensagem'] == 'sucesso'): ?>
          <div class="text-center mb-4">
              <span class="badge bg-success p-2">Criado com sucesso!</span>
          </div>
      <?php elseif (isset($_GET['mensagem']) && $_GET['mensagem'] == 'erro'): ?>
          <div class="text-center mb-4">
              <span class="badge bg-danger p-2">Ocorreu um erro ao atualizar o registro.</span>
          </div>
      <?php elseif (isset($_GET['mensagem']) && $_GET['mensagem'] == 'erro'): ?>
          <div class="text-center mb-4">
              <span class="badge bg-danger p-2">Ocorreu um erro ao criar o registro.</span>
          </div>
      <?php endif; ?>

      <div id="alertaAlteracao" class="text-center mb-4 d-none">
          <span class="badge bg-danger p-2">Nenhuma alteração detectada. Atualização cancelada.</span>
      </div>

      <h2 class="text-center mb-4"><?php echo $codigo ? 'Atualizar Incidente' : 'Novo Incidente'; ?></h2>

      <form id="formIncidente" method="POST" action="<?php echo $codigo ? '/ITSM/formulario/atualiza_registro.php' : '/ITSM/formulario/cria_registro.php'; ?>">
          
          <input type="hidden" name="tipo" value="incidente">
        
          <?php if ($codigo): ?>
              <!-- Campo Código só aparece na edição -->
              <div class="mb-3">
                  <label class="form-label">Código</label>
                  <input type="text" class="form-control" value="<?php echo htmlspecialchars($codigo); ?>" readonly>
                  <input type="hidden" name="codigo_incidente" value="<?php echo htmlspecialchars($codigo); ?>">
              </div>

              <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select class="form-select" name="status" id="status" required <?= $isReadOnly ? 'disabled' : '' ?>>
                      <option value="1" <?php echo $incidente['status'] == 1 ? 'selected' : ''; ?>>Aberto</option>
                      <option value="2" <?php echo $incidente['status'] == 2 ? 'selected' : ''; ?>>Em andamento</option>
                      <option value="6" <?php echo $incidente['status'] == 6 ? 'selected' : ''; ?>>Em análise</option>
                      <option value="5" <?php echo $incidente['status'] == 5 ? 'selected' : ''; ?>>Pendente</option>
                      <option value="3" <?php echo $incidente['status'] == 3 ? 'selected' : ''; ?>>Resolvido</option>
                      <option value="4" <?php echo $incidente['status'] == 4 ? 'selected' : ''; ?>>Fechado</option>
                      <option value="8" <?php echo $incidente['status'] == 8 ? 'selected' : ''; ?>>Cancelado</option>
                  </select>
                  <?php if ($isReadOnly): ?>
                    <input type="hidden" name="status" value="<?= $incidente['status'] ?>">
                  <?php endif; ?>
              </div>

              <?php if ($_SESSION["usuario_funcao"] == "Atendente" || $_SESSION["usuario_funcao"] == "Administrador"): ?>
                <div class="mb-3">
                  <label class="form-label">Atribuído para</label>
                  <select class="form-select" name="atribuido_para" id="atribuido_para" <?= $isReadOnly ? 'disabled' : '' ?>>
                    <option value="">Selecione</option>
                    <?php
                      $usuarios = $con->query("SELECT id, nome FROM usuarios WHERE funcao='Atendente' OR funcao='Administrador' ORDER BY nome");
                      while ($u = $usuarios->fetch_assoc()):
                    ?>
                      <option value="<?= $u['id'] ?>" <?= $incidente['atribuido_para'] == $u['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u['nome']) ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                  <?php if ($isReadOnly): ?>
                    <input type="hidden" name="atribuido_para" value="<?= $incidente['atribuido_para'] ?>">
                  <?php endif; ?>
                </div>
              <?php endif; ?>

          <?php endif; ?>

          <?php if (!$codigo): ?>
            <input type="hidden" name="status" value="1">
          <?php endif; ?>

          <div class="mb-3">
              <label class="form-label">Título</label>
              <input type="text" class="form-control" name="titulo" id="titulo" required placeholder="Digite o título do incidente..." value="<?php echo htmlspecialchars($incidente['titulo']); ?>" <?= $isReadOnly ? 'readonly' : '' ?>>
          </div>

          <div class="mb-3">
              <label class="form-label">Descrição</label>
              <textarea class="form-control" name="descricao" id="descricao" rows="4" required placeholder="Descreva o problema..." <?= $isReadOnly ? 'readonly' : '' ?>><?php echo htmlspecialchars($incidente['descricao']); ?></textarea>
          </div>

          <div class="mb-3">
              <label class="form-label">Prioridade</label>
              <select class="form-select" name="prioridade" id="prioridade" required <?= $isReadOnly ? 'disabled' : '' ?>>
                  <option value="Baixa" <?php echo $incidente['prioridade'] == 'Baixa' ? 'selected' : ''; ?>>Baixa</option>
                  <option value="Média" <?php echo $incidente['prioridade'] == 'Média' ? 'selected' : ''; ?>>Média</option>
                  <option value="Alta" <?php echo $incidente['prioridade'] == 'Alta' ? 'selected' : ''; ?>>Alta</option>
                  <option value="Crítica" <?php echo $incidente['prioridade'] == 'Crítica' ? 'selected' : ''; ?>>Crítica</option>
              </select>
              <?php if ($isReadOnly): ?>
                <input type="hidden" name="prioridade" value="<?= $incidente['prioridade'] ?>">
              <?php endif; ?>
          </div>

        <div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
            <div class="d-flex gap-3">
              <?php
                $isCriador = $_SESSION['usuario_id'] == $incidente['criado_por'];
                $permitido = ($_SESSION['usuario_funcao'] == 'Administrador' && isset($_GET['codigo'])) || $isCriador;
                $statusAtual = (int)$incidente['status'];
              ?>
                  <button type="button" class="btn btn-outline-secondary" onclick="history.back();">Voltar</button>
                  <?php if (
                      (!in_array($statusAtual, [7, 8, 4]) && $_SESSION['usuario_funcao'] != 'Solicitante') 
                      || $_SESSION['usuario_funcao'] == 'Administrador' 
                      || empty($codigo)
                  ): ?>                    
                    <button type="submit" class="btn btn-dark" name="acao" value="atualizar"><?php echo $codigo ? 'Atualizar' : 'Criar'; ?></button>
                  <?php endif; ?>
                  <?php if ($permitido && $statusAtual == 3): ?>
                    <button type="submit" class="btn btn-warning" name="acao" value="reabrir">Reabrir</button>
                  <?php endif; ?>
                  <?php if ($permitido && !in_array($statusAtual, [7, 8, 4])): ?>
                    <button type="submit" class="btn btn-success" name="acao" value="concluir">Concluir</button>
                  <?php endif; ?>
                  <?php if ($permitido && !in_array($statusAtual, [7, 8, 4, 3])): ?>
                    <button type="submit" class="btn btn-danger" name="acao" value="cancelar">Cancelar</button>
                  <?php endif; ?>
            </div>
        </div>
      </form>
  </div>
</main>

<script>
// JavaScript para bloquear envio se não houver alteração no modo Atualizar
const form = document.getElementById('formIncidente');
const alerta = document.getElementById('alertaAlteracao');
const originalData = {
  titulo: document.getElementById('titulo').value,
  descricao: document.getElementById('descricao').value,
  status: document.getElementById('status')?.value || '',
  prioridade: document.getElementById('prioridade')?.value || '',
  atribuido_para: document.getElementById('atribuido_para')?.value || ''
};

form.addEventListener('submit', function(e) {
  <?php if ($codigo): ?>
  const currentData = {
    titulo: document.getElementById('titulo').value,
    descricao: document.getElementById('descricao').value,
    status: document.getElementById('status')?.value || '',
    prioridade: document.getElementById('prioridade')?.value || '',
    atribuido_para: document.getElementById('atribuido_para')?.value || ''
  };

  let acao = document.activeElement?.value || '';

  if (JSON.stringify(originalData) === JSON.stringify(currentData) && acao == 'atualizar') {
    e.preventDefault();
    alerta.classList.remove('d-none');
    setTimeout(() => {
      alerta.classList.add('d-none');
    }, 3000);
  }
  <?php endif; ?>
});
</script>

    <!-- Footer -->
<footer class="mt-5">
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
