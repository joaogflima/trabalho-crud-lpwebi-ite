<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: /ITSM/login/login.php");
    exit;
?>