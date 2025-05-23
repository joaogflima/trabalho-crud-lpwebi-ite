<?php
    session_start();

    include("conexao_banco_login.php");

    $usuario = @$_POST["username"];
    $senha = @$_POST["password"];

    if (empty($usuario) || empty($senha)) {
        header('Location: login.php?erro_login=usuario');
        exit();
    }

    $sql = "SELECT * FROM `usuarios` WHERE `login` = '$usuario'";
    $resultado = $con->query($sql);
    $dados = mysqli_fetch_assoc($resultado);

    if (!$dados) {
        
        header('Location: login.php?erro=usuario');
        exit();

    } else {
        if($dados["ativo"] == 0){
            header('Location: login.php?erro=inativo');
            exit();

        } elseif ($senha === $dados["senha"]) {
         
            $_SESSION["usuario_id"] = $dados["id"];
            $_SESSION["usuario_login"] = $dados["login"];
            $_SESSION["usuario_nome"] = $dados["nome"];
            $_SESSION["usuario_email"] = $dados["email"];
            $_SESSION["usuario_funcao"] = $dados["funcao"];
            $_SESSION["logado"] = true;

            header('Location: /ITSM/home/index.php');
            exit();

        } else {
            
            header('Location: login.php?erro=senha');
            exit();
        }
    }
?>
