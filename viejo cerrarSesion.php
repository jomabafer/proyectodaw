<?php
session_start();
echo ($_SESSION["usuario"]);
echo ($_SESSION["clave"]);
unset ($_SESSION["usuario"]);
unset ($_SESSION["clave"]);
session_destroy();
//header('Location: index.php');
//header('Location: formulario.php');
echo ($_SESSION["usuario"]);
echo ($_SESSION["clave"])
//exit;
?>