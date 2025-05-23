<?php
    include("conexao_banco_login.php");

    $usuario = @$_POST["username"];
    $senha = @$_POST["password"];
    $nome_completo = @$_POST["nome"];
    $email = @$_POST["email"];

    if (empty($usuario) || empty($senha)) {
        header("Location: cadastro_login.php?erro=Campos obrigatórios não preenchidos");
        exit();
    }

    $sql_verifica = "SELECT * FROM usuarios WHERE login = '$usuario'";
    $resultado = $con->query($sql_verifica);

    if ($resultado->num_rows > 0) {
        header("Location: cadastro_login.php?erro=usuario_existente");
        exit();
    }

    // Se não existir, cadastra o usuário
    $sql = "INSERT INTO usuarios (login, senha, nome, email, funcao) VALUES ('$usuario', '$senha', '$nome_completo', '$email', 'Solicitante')";

    if ($con->query($sql) === TRUE) {
        header("Location: login.php?sucesso=cadastro_realizado");
        exit();
    } else {
        header("Location: cadastro_login.php?erro=01");
        exit();
    }
?>

