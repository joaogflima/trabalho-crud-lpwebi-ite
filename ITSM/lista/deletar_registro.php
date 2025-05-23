<?php
    session_start();
    include("conexao_banco_lista.php");


    $sql = "";
    $caminho_retorno = $_SERVER['HTTP_REFERER'];

    $id_usuario = @$_GET['usuario'];
    $id_incidente = @$_GET['codigo_incidente'];
    $id_requisicao = @$_GET['codigo_requisicao'];

    if (!empty($id_usuario)) {
        // Verifica se existem registros relacionados
        $check1 = $con->query("SELECT 1 FROM incidentes WHERE criado_por = '$id_usuario' LIMIT 1");
        $check2 = $con->query("SELECT 1 FROM requisicoes WHERE criado_por = '$id_usuario' LIMIT 1");
    
        if ($check1->num_rows > 0 || $check2->num_rows > 0) {
            $_SESSION['mensagem'] = "Não é possível deletar este usuário. Existem registros relacionados.";
            header("Location: $caminho_retorno");
            exit();
        }
        if($id_usuario == $_SESSION["usuario_id"]){
            $_SESSION['mensagem'] = "Não é possível deletar este usuário.";
            header("Location: $caminho_retorno");
            exit();
        }
    
        $sql = "DELETE FROM usuarios WHERE id = '$id_usuario'";
    } elseif (!empty($id_incidente)) {
        $sql = "DELETE FROM incidentes WHERE codigo = '$id_incidente'";
    } elseif (!empty($id_requisicao)) {
        $sql = "DELETE FROM requisicoes WHERE codigo = '$id_requisicao'";
    } else {
        $_SESSION['mensagem'] = "Nenhum registro selecionado para exclusão.";
        header("Location: $caminho_retorno");
        exit();
    }

    // Executa a exclusão
    if ($con->query($sql) === TRUE) {
        $_SESSION['mensagem'] = "Registro deletado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao deletar registro: " . $con->error;
    }

    header("Location: $caminho_retorno");
    exit();
?>
