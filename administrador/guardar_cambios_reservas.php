<?php
// Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";

/*Permite comprobar si se recibió un formulario mediante método post, si no se recibió nada muestra un 
mensaje de error*/
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acceso no válido.");
}

/*Si se recibió el formulario mediante método post asigna los valores recibidos a las distintas variables*/
$ID = (int) ($_POST["ID"] ?? 0);
$cliente = trim($_POST["cliente"] ?? "");
$email = trim($_POST["email"] ?? "");
$whatsapp = trim($_POST["whatsapp"] ?? "");
$fecha = $_POST["fecha"] ?? "";
$hora = $_POST["hora"] ?? "";
$personas = (int) ($_POST["personas"] ?? 0);

/*Prepara la conexión con la base de datos para poder realizar la consulta y pasa los parámetros a cada uno de
los datos*/
$consulta = $conexion->prepare(
    "UPDATE reservas
    SET cliente = ?, email = ?, whatsapp = ?, fecha = ?, hora = ?, personas = ?
    WHERE ID = ?"
);

/*Permite asignar los valores a cada uno de los parámetros de la base de datos y el tipo de dato que son*/
$consulta->bind_param(
    "sssssii",
    $cliente,
    $email,
    $whatsapp,
    $fecha,
    $hora,
    $personas,
    $ID
);

/*Si se ejecuta la consulta correctamente redirige a la página ver_reservas.php para poder ver los cambios 
realizados, sino se ejecutó correctamente muestra un mensaje de error*/
if ($consulta->execute()) {
    header("Location: ver_reservas.php");
    exit;
} else {
    die("No se pudieron guardar los cambios.");
}