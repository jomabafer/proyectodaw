<?php
session_start();
session_unset();
session_destroy();
//header('Location: formulario.php');
header('Location: ../index.php');
//header('Location: formulario.php');
//exit;
?>