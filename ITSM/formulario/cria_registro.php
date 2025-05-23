<?php
session_start();
include("conexao_banco_form.php");

if (isset($_POST["tipo"])) {

    $titulo = @$_POST['titulo'];
    $descricao = @$_POST['descricao'];
    $status = @$_POST['status'];
    $prioridade = @$_POST['prioridade'];
    $tipo_requisicao = @$_POST['tipo_requisicao'];  

    $tipo = @$_POST["tipo"];

    if (empty($titulo) || empty($descricao) || empty($status)) {
        $_SESSION['mensagem'] = "Todos os campos devem ser preenchidos.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    if ($tipo === 'requisicao') {
        $sql = "INSERT INTO requisicoes (titulo, descricao, status, tipo, criado_por) 
                VALUES ('$titulo', '$descricao', '$status', '$tipo_requisicao', ".$_SESSION["usuario_id"].")";
    } elseif ($tipo === 'incidente') {
        $sql = "INSERT INTO incidentes (titulo, descricao, status, prioridade, criado_por) 
                VALUES ('$titulo', '$descricao', '$status', '$prioridade', ".$_SESSION["usuario_id"].")";
    } else {
        $_SESSION['mensagem'] = "Erro: Tipo de registro não identificado.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    if ($con->query($sql) === TRUE) {
        $last_id = mysqli_insert_id($con);

        // Buscar o código já salvo no banco
        if ($tipo === 'requisicao') {
            $consulta = "SELECT codigo FROM requisicoes WHERE id = $last_id";
            $formulario = "form_requisicao.php";
        } elseif ($tipo === 'incidente') {
            $consulta = "SELECT codigo FROM incidentes WHERE id = $last_id";
            $formulario = "form_incidente.php";
        }

        $resultado = $con->query($consulta);
        $codigo = '';

        if ($resultado && $row = $resultado->fetch_assoc()) {
            $codigo = $row['codigo'];
        }

        if (!empty($codigo)) {
            header("Location: /ITSM/formulario/$formulario?codigo=$codigo&mensagem=sucesso");
            exit();
        } else {
            $_SESSION['mensagem'] = "Erro ao localizar o código do registro.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        $_SESSION['mensagem'] = "Erro ao criar registro: " . $con->error;
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>
