<?php
session_start();
if($_SESSION["logado"] != true){
  header("Location: /ITSM/login/login.php");
  exit();
}
include("conexao_banco_lista.php");

$codigo = @$_GET['codigo'];
$requisicao = [
    'titulo' => '',
    'descricao' => '',
    'status' => '',
    'prioridade' => '',
    'criado_por' => ''
];

if (!empty($codigo)) {
    $sql = "SELECT * FROM requisicoes WHERE codigo='$codigo'";
    $resultado = $con->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $requisicao = mysqli_fetch_assoc($resultado);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Requisições | Plataforma ITSM</title>
<link rel="shortcut icon" href="/ITSM/imagens/ICON.png" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
html, body {
  height: 100%;
}
body {
  display: flex;
  flex-direction: column;
  background-color: #f8f9fa;
  margin: 0;
  padding: 0;
}
main {
  flex: 1;
  width: 100%;
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
<nav class="navbar navbar-expand-lg">
<div class="container-fluid ps-3">
  <a class="navbar-brand" href="/ITSM/home/index.php">
    <img src="/ITSM/imagens/ITSM-LOGO-HORIZONTAL.png" alt="Logo">
  </a>
  <div class="navbar-title bg-black text-white px-2 py-0 rounded custom-border">
      Lista de Requisições
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
    <form class="d-flex me-3" method="GET" action="">
      <input class="form-control me-2" type="search" name="pesquisa" value="<?php echo htmlspecialchars(@$_GET['pesquisa']); ?>" placeholder="Buscar..." aria-label="Search">
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
<div class="table-responsive">
<?php if (isset($_SESSION['mensagem'])): ?>
  <div class="container mt-3">
    <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
      <?php 
        echo $_SESSION['mensagem']; 
        unset($_SESSION['mensagem']);
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
  </div>
<?php endif; ?>
<table class="table table-hover table-bordered w-100">
<thead class="table-dark">
<tr>
  <th>Código</th>
  <th>Título</th>
  <th>Tipo</th>
  <th>Status</th>
  <th>Descrição</th>
  <th>Atribuído para</th>
  <th>Criado por</th>
  <th>Criado em</th>
  <th>Editar</th>
  <?php if($_SESSION["usuario_funcao"] == "Administrador"): ?>
  <th>Deletar</th>
  <?php endif; ?>
</tr>
</thead>
<tbody>
<?php
$pesquisa = @$_GET['pesquisa'] ?? '';

$sql = "
SELECT requisicoes.*, 
       criador.nome AS nome_criador, 
       status.nome AS nome_status,
       atendente.nome AS nome_atendente
FROM requisicoes
LEFT JOIN usuarios AS criador ON requisicoes.criado_por = criador.id
LEFT JOIN status ON requisicoes.status = status.id
LEFT JOIN usuarios AS atendente ON requisicoes.atribuido_para = atendente.id
WHERE requisicoes.codigo LIKE '%$pesquisa%' 
   OR requisicoes.titulo LIKE '%$pesquisa%' 
   OR requisicoes.descricao LIKE '%$pesquisa%'
";

$resultado = $con->query($sql);

foreach ($resultado as $linha) {
    $corStatus = match ($linha['nome_status']) {
        'Aberto' => 'primary',
        'Em andamento' => 'warning',
        'Pendente' => 'secondary',
        'Resolvido' => 'success',
        'Fechado' => 'dark',
        'Cancelado' => 'danger',
        'Concluído' => 'success',
        'Em análise' => 'info',
        default => 'secondary'
    };

    echo "
    <tr>
        <td><a href='/ITSM/formulario/form_requisicao.php?codigo=" . $linha['codigo'] . "' class='link-dark' title='Abrir requisição'>" . $linha['codigo'] . "</a></td>
        <td>" . $linha['titulo'] . "</td>
        <td><span class='badge bg-secondary'>" . $linha['tipo'] . "</span></td>
        <td><span class='badge bg-{$corStatus}'>" . $linha['nome_status'] . "</span></td>
        <td>" . $linha['descricao'] . "</td>
        <td>" . htmlspecialchars($linha['nome_atendente']) . "</td>
        <td>" . htmlspecialchars($linha['nome_criador']) . "</td>
        <td>" . $linha['criado_em'] . "</td>
        <td>
            <a href='/ITSM/formulario/form_requisicao.php?codigo=" . $linha['codigo'] . "' class='btn btn-sm btn-outline-primary'>
                <i class='bi bi-pencil-square'></i>
            </a>
        </td>";
        if ($_SESSION["usuario_funcao"] == "Administrador") {
          echo "<td>
                  <button type='button' class='btn btn-sm btn-outline-danger' 
                      onclick='confirmarExclusao(\"" . htmlspecialchars($linha['codigo']) . "\")'>
                      <i class='bi bi-trash'></i>
                  </button>
                </td>";
        }
    echo "
    </tr>
    ";
}
?>
</tbody>
</table>
</div>
</main>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmarDelete" tabindex="-1" aria-labelledby="confirmarDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarDeleteLabel">Confirmar Exclusão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        Você tem certeza que deseja excluir este registro?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="confirmarExcluirBtn" href="#" class="btn btn-danger">Excluir</a>
      </div>
    </div>
  </div>
</div>

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

<script>
function confirmarExclusao(codigo) {
    var confirmarBtn = document.getElementById('confirmarExcluirBtn');
    confirmarBtn.href = '/ITSM/lista/deletar_registro.php?codigo_requisicao=' + encodeURIComponent(codigo);
    var confirmarModal = new bootstrap.Modal(document.getElementById('confirmarDelete'));
    confirmarModal.show();
}
</script>

</body>
</html>
