<?php
/*protege el panel del administrador para que solo pueda verla un administrador que inició sesión 
comprobando que exista la variable que se guarda cuando el inición de sesión es correcto*/
session_start();
if (!isset($_SESSION["administrador_id"])){ 
    header("Location: inicio_sesion.php"); 
    exit;
}
// Incluye el archivo que crea la conexión mysqli.
require_once "../Backend/conexion.php";
//Permite obtener las distintas reservas y las ordena por fecha y hora de manera ascendente
$sql = "SELECT ID, cliente, email, whatsapp, fecha, hora, personas
        FROM reservas
        ORDER BY fecha, hora";
/*Ejecuta la consulta SQL teniendo en cuenta la conexión y la variable sql que contiene los distintos datos
de la reserva que se desean insertar en el panel del administrador*/
$resultado = mysqli_query($conexion, $sql);
//Muestra un mensaje de error en cado que no funcione la consulta
if (!$resultado) {
    die("Error al consultar las reservas.");
}
/* Cuenta cuántas reservas realizadas hay en la tabla */
$sqlCantidad = "SELECT COUNT(*) AS cantidad FROM reservas";
$resultadoCantidad = mysqli_query($conexion, $sqlCantidad);
//Si se produjo un error en obtener el número de reservas muestra un mensaje
if (!$resultadoCantidad) {
    die("Error al contar las reservas.");
}
//Permite acceder a las distintas filas de la variable "Resultado cantidad" y mostrar la cantidad de reservas hechas
$filaCantidad = mysqli_fetch_assoc($resultadoCantidad);
$cantidadReservas = $filaCantidad["cantidad"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas del restaurante</title>
    <!--Conexión con el archivo .CSS-->
    <link rel="stylesheet" href="ver_reservas.css">
    <!--Conexión con la página de íconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <!--Barra de navegación-->
    <header>
        <nav>
            <!--Logo del restaurante-->
            <div class="logo">
            <h1>La Toscana</h1>
            <h2>Mendoza-Argentina</h2>
            </div>
        </nav>
    </header>
    <!--Estructura de la tabla la cual contiene todas las reservas realizadas en el restaurante-->
    <main>
        <div class="tabla">
            <!--Título de la sección de ver reservas del restaurante-->
            <h2>🍽️Reservas del Restaurante</h2>
            <!--Formulario que permite enviar los datos al archivo modificar_reserva.php para realizar la 
            modificación-->
            <form action="modificar_reserva.php" method="POST">
            <!--Tabla donde se encuentran las distintas reservas-->
                <table class="reservas">
                    <tr>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Personas</th>
                        <th>Seleccionar</th>
                    </tr>
                    <!--Verifica si hay más de una fila y muestra los datos guardados en las distintas columnas-->
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($reserva = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reserva["cliente"]); ?></td>
                                <td><?php echo htmlspecialchars($reserva["email"]); ?></td>
                                <td><?php echo htmlspecialchars($reserva["whatsapp"]); ?></td>
                                <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($reserva["fecha"]))); ?></td>
                                <td><?php echo htmlspecialchars(date("H:i", strtotime($reserva["hora"]))); ?></td>
                                <td><?php echo htmlspecialchars($reserva["personas"]); ?></td>
                                <td><input type="radio" name="ID" value="<?= (int) $reserva["ID"]; ?>" required></td>
                            </tr>
                        <?php endwhile; ?>
                    <!--si no se cumple la condición y hay 0 filas muestra un mensaje-->
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No hay reservas realizadas.</td>
                        </tr>
                    <?php endif; ?>
                </table>
                <!--Botones para que el administrador realice las distintas tareas-->
                <div class="acciones">
                    <h3 class="cantidad"> Cantidad de Reservas: <?php echo $cantidadReservas; ?></h3>
                    <button type="button" class="panel"><a href="opciones_admin.php">Volver al Panel</a></button>
                    <button type="submit" class="modificar">Modificar</button>
                    <button type="submit" class="eliminar" formaction="eliminar_reserva.php"
                    onclick="return confirm('¿Está seguro que desea eliminar esta reserva?');">Eliminar</button>
                </div>
            </form>
        </div>
    </main>
    <!--Pie de página-->
    <footer>
        <!--Logo del restaurante-->
        <div class="logo">
            <h1>La Toscana</h1>
            <h2>Mendoza-Argentina</h2>
        </div>
        <!--Características del restaurante-->
        <div class="detalles">
            <ul class="pie">
                <li>
                    La Toscana Palmares
                </li>
                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    Ruta Panamericana 2650
                    (Palmares Open Mall) - Godoy Cruz - Mendoza
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    latoscanapalmares@gmail.com
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    +54 261 615 9431
                </li>
            </ul>
        </div>
        <!--Redes sociales del restaurante-->
        <div class="redes">
            <ul class="sociales">
                <h1>Seguinos</h1>
                <li>
                    <a href="https://www.instagram.com/la_toscana_palmares" target="_blank">
                    <i class="fa-brands fa-instagram"></i> Instagram
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/profile.php?id=61595594422052" target="_blank">
                    <i class="fa-brands fa-facebook"></i> Facebook
                    </a>
                </li>
            </ul>
    </footer>
</body> 
</html>