<?php
// Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";

/*Verifica que se recibi el ID por método POST sino se recibe muestra un mensaje de error*/
if (!isset($_POST["ID"])) {
    die("Seleccioná una reserva válida.");
}

/*Si se recibe el ID lo asigna a la variable $ID, prepara la conexión para hacer la consulta a la base de datos
y pasa el parámetro*/
$ID = (int) $_POST["ID"];

$consulta = $conexion->prepare(
    "DELETE FROM reservas WHERE ID = ?"
);

/*Le asigna el valor al párametro y el tipo de dato*/
$consulta->bind_param("i", $ID);

/*Si la consulta se ejecuta correctamente redirige al archivo ver_reservas.php para ver los cambios y si no
se ejecuta correctamente muestra un mensaje de error*/
if ($consulta->execute()) {
    header("Location: ver_reservas.php");
    exit;
} else {
    die("No se pudo eliminar la reserva.");
}
?>