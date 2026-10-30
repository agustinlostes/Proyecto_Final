<?php
// Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";

$id = (int) ($_POST["plato"] ?? 0);

/*Comprueba si el ID recibido es menor o igual a 0 y muestra una alerta la cual permite volver automaticamente
a la página anterior*/
if ($id <= 0) {
    echo "<script>
        alert('Seleccioná un plato para eliminar.');
        window.history.back(); // Regresa al formulario anterior
    </script>";
    exit; 
}

/*Prepara la conexión para realizar la consulta a la base de datos y pasa el parámetro, luego asigna el valor
al parámetro y el tipo de dato*/
$consulta = $conexion->prepare("DELETE FROM menu WHERE ID = ?");
$consulta->bind_param("i", $id);

/*Si la consulta se ejecutó correctamente y la consulta afecto a mas de 0 filas, es decir, por lo menos una
redirige a la página ver_platos.php para poder ver los cambios realizados, sino muestra un mensaje de error */
if ($consulta->execute() && $consulta->affected_rows > 0) {
    header("Location: ver_platos.php");
    exit;
}
echo "No se pudo eliminar el plato.";

$consulta->close();
$conexion->close();
?>