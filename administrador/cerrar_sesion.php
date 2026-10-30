<?php
session_start(); /*inicia o recupera la sesión actual para poder modificarla.*/
$_SESSION = [];/*borra las variables guardadas en esa sesión*/
session_destroy();/*destruye la sesión en el servidor.*/
header("Location: inicio_sesion.php");/*le indica al navegador que vaya a inicio_sesion.php*/
exit;