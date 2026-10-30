<?php
//Asigna los valores a las distintas variables con los datos de la base de datos
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "restaurante";
//Conexión con la base de datos utilizando mysqli
$conexion = new mysqli(
    $servidor,
    $usuario,
    $password,
    $base_datos
//Verificar la conexión con la base de datos
);
if ($conexion->connect_error)
    {
        die("Error de conexión: " . $conexion->connect_error);
    }
//Establecer el juego de caracteres que va a utilizar la conexión
$conexion->set_charset("utf8mb4");
?>