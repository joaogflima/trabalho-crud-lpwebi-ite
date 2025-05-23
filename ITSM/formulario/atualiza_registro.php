<?php
session_start();
include("conexao_banco_form.php");

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['id'])) {

    $nome = @$_POST['nome'];
    $login = @$_POST['username'];
    $email = @$_POST['email'];
    $id = @$_POST['id'];
    $funcao = @$_POST['funcao'];
    $ativo = @$_POST['ativo'];

    $sql = "UPDATE usuarios SET nome='$nome', email='$email', login='$login', funcao='$funcao', ativo='$ativo' WHERE login='$login' OR id='$id'";
    $sqlselect = "SELECT * FROM `usuarios` WHERE login='$login'";

    if($login == $_SESSION["usuario_login"]){
        $caminho = '/ITSM/formulario/form_perfil.php?mensagem=atualizado';
        $caminhoerro = '/ITSM/formulario/form_perfil.php?mensagem=erro';
    } else{
        $caminho = "/ITSM/formulario/form_usuario.php?id=".$id."&mensagem=atualizado";
        $caminhoerro = "/ITSM/formulario/form_usuario.php?id=".$id."&mensagem=erro";
    }

}else if (isset($_POST['username']) && isset($_POST['email']) && !isset($_POST['id'])) {

    $nome = @$_POST['nome'];
    $login = @$_POST['username'];
    $email = @$_POST['email'];

    $sql = "UPDATE usuarios SET nome='$nome', email='$email', login='$login' WHERE login='$login'";
    $sqlselect = "SELECT * FROM `usuarios` WHERE login='$login'";

    if($login == $_SESSION["usuario_login"]){
        $caminho = '/ITSM/formulario/form_perfil.php?mensagem=atualizado';
        $caminhoerro = '/ITSM/formulario/form_perfil.php?mensagem=erro';
    } else{
        $caminho = "/ITSM/formulario/form_usuario.php?id=".$id."&mensagem=atualizado";
        $caminhoerro = "/ITSM/formulario/form_usuario.php?id=".$id."&mensagem=erro";
    }

}  else if (isset($_POST['codigo_incidente']) && isset($_POST['acao'])) {
    
    $codigo = @$_POST['codigo_incidente'];
    $titulo = @$_POST['titulo'];
    $descricao = @$_POST['descricao'];
    $status = @$_POST['status'];
    $prioridade = @$_POST['prioridade'];
    $atribuido_para = @$_POST['atribuido_para'];
    $atribuido_para = $atribuido_para !== '' ? "'$atribuido_para'" : "NULL";

    switch ($_POST['acao']) {
        case 'concluir':
            $status = 4;
            break;
        case 'cancelar':
            $status = 8;
            break;
        case 'reabrir':
            $status = 1;
            break;
        case 'atualizar':
        default:
            break;
    }

    $atribuido_para = isset($_POST['atribuido_para']) && $_POST['atribuido_para'] !== '' ? (int)$_POST['atribuido_para'] : null;

    $sql = "UPDATE incidentes SET titulo='$titulo', descricao='$descricao', status=$status, prioridade='$prioridade'";

    if (!is_null($atribuido_para)) {
        $sql .= ", atribuido_para=$atribuido_para";
    }

    $sql .= " WHERE codigo='$codigo'";
    $caminho = "/ITSM/formulario/form_incidente.php?codigo=$codigo&mensagem=atualizado";
    $caminhoerro = "/ITSM/formulario/form_incidente.php?codigo=$codigo&mensagem=erro";

} else if (isset($_POST['codigo_requisicao']) && isset($_POST['acao'])) {

    $codigo = @$_POST['codigo_requisicao'];
    $titulo = @$_POST['titulo'];
    $descricao = @$_POST['descricao'];
    $tipo_requisicao = @$_POST['tipo_requisicao'];
    $status = @$_POST['status'];

    switch ($_POST['acao']) {
        case 'concluir':
            $status = 7;
            break;
        case 'cancelar':
            $status = 8;
            break;
        case 'reabrir':
            $status = 1;
            break;
        case 'atualizar':
        default:
            break;
    }

    $atribuido_para = isset($_POST['atribuido_para']) && $_POST['atribuido_para'] !== '' ? (int)$_POST['atribuido_para'] : null;

    $sql = "UPDATE requisicoes SET titulo='$titulo', descricao='$descricao', status=$status, tipo='$tipo_requisicao'";

    if (!is_null($atribuido_para)) {
        $sql .= ", atribuido_para=$atribuido_para";
    }

    $sql .= " WHERE codigo='$codigo'";
    $caminho = "/ITSM/formulario/form_requisicao.php?codigo=$codigo&mensagem=atualizado";
    $caminhoerro = "/ITSM/formulario/form_requisicao.php?codigo=$codigo&mensagem=erro";
} else if (isset($_POST['username']) && isset($_POST['password'])) {

    $senha = @$_POST['password'];
    $login = @$_POST['username'];
    $id = @$_POST['id'];
    $sql = "UPDATE usuarios SET senha='$senha' WHERE login='$login'";

    if($login == $_SESSION['usuario_login']){
        $caminho = '/ITSM/formulario/form_perfil.php?mensagem=atualizado';
        $caminhoerro = '/ITSM/formulario/form_perfil.php?mensagem=erro';
    } else{
        $caminho = "/ITSM/formulario/form_usuario.php?id=".$id."&mensagem=atualizado";
        $caminhoerro = "/ITSM/formulario/form_usuario.php?id=".$id."&mensagem=erro";
    }
} else {
    header('Location: /ITSM/home/index.php');
    exit();
}

if ($con->query($sql) === TRUE) {
    if(isset($sqlselect)){

        $dados = mysqli_fetch_assoc($con->query($sqlselect));

        if((isset($_POST["login"]) && $_POST["login"] == $_SESSION["usuario_login"]) || (isset($_POST["username"]) && $_POST["username"] == $_SESSION["usuario_login"])){
        $_SESSION["usuario_id"] = $dados["id"];
        $_SESSION["usuario_login"] = $dados["login"];
        $_SESSION["usuario_nome"] = $dados["nome"];
        $_SESSION["usuario_email"] = $dados["email"];
        $_SESSION["usuario_funcao"] = $dados["funcao"];
        }
    }
    header("Location: $caminho");
} else {
    header("Location: $caminhoerro");
}
exit();
?>
