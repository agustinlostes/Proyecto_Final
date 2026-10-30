<?php
//Inicia la sesión del usuario y requiere la conexión con la base de datos
session_start();
require_once "../Backend/conexion.php";

//Permite verificar que la página haya recibido los datos del formulario mediante el método POST.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: inicio_sesion.php");
    exit;
}

/*obtiene el nombre de usuario y contraseña enviado por el formulario, le quita espacios al principio y al final 
al nombre del usuario y lo guarda en la variable $usuario*/
$usuario = trim($_POST["nombre_usuario"] ?? "");
$contraseña = $_POST["contrasena"] ?? "";

//Determina la consulta SQL determinando que datos se quieren traer de la tabla
$sql = "SELECT ID, nombre_usuario, contrasena_hash
        FROM administrador
        WHERE nombre_usuario = ?";

/*Prepara la consulta SQL, le asigna el valor a nombre_usuario y el tipo de dato, ejecuta la consulta y obtiene
el resultado*/
$sentencia = $conexion->prepare($sql);
$sentencia->bind_param("s", $usuario);
$sentencia->execute();
$resultado = $sentencia->get_result();

/*Convierte el resultado de la consulta en un arreglo asociativo, es decir, se puede acceder a cada valor 
por el nombre de su columna.*/
$administrador = $resultado->fetch_assoc();

/*Permite verificar el usuario y la contraseña ingresada sean los correctos y genera la sesión*/
if ($administrador && password_verify($contraseña, $administrador["contrasena_hash"])) {
    session_regenerate_id(true);

/*Guarda el nombre del usuario y la contraseña y redirige al panel del administrador si coinciden los datos*/
    $_SESSION["administrador_id"] = $administrador["ID"];
    $_SESSION["administrador_usuario"] = $administrador["nombre_usuario"];
    header("Location: opciones_admin.php");
    exit;
}

/*Si no coinciden los datos redirige de nuevo al formulario para iniciar sesión nuevamente*/
header("Location: inicio_sesion.php?error=credenciales");
exit;